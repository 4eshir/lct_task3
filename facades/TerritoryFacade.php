<?php

namespace app\facades;

use app\components\arrangement\TerritoryArrangementManager;
use app\components\arrangement\TerritoryConcept;
use app\models\common\FixedArrangement;
use app\models\work\FixedArrangementWork;
use app\models\work\ObjectWork;
use app\models\work\TerritoryWork;
use yii\db\Exception;

class TerritoryFacade
{
    const OPTIONS_DEFAULT = 0; // стандартная генерация расстановки
    const OPTIONS_BUDGET_ECONOMY = 1; // генерация максимально экономичной расстановки
    const OPTIONS_SIMILAR = 2; // генерация аналогичной расстановки (требуется передать пример в массив $params)

    public ArrangementModelFacade $model;
    public TerritoryArrangementManager $manager;

    public function __construct(TerritoryArrangementManager $manager)
    {
        $this->manager = $manager;
    }

    public function prepare(int $territoryId)
    {
        $this->manager->setTerritory(TerritoryConcept::TYPE_BASE_WEIGHTS, $territoryId);
        $matrix = array_fill(0, $this->manager->territory->widthCellCount, array_fill('0', $this->manager->territory->lengthCellCount, '0'));
        $this->model = new ArrangementModelFacade($matrix, [], []);
    }

    /**
     * Генерация расстановки объектов на территории
     * @param string $generateType тип генерации из списка констант @see TerritoryConcept
     * @param int $territoryId id территории @see TerritoryWork
     * @param int $addGenType тип генерации расстановки по доп параметрам @see TerritoryFacade константы OPTIONS
     * @param int|null $templateId ID шаблона расстановки, по которому произвести генерацию
     * @param array $params необязательный параметр, массив доп параметров
     *          ('votes' => пример: [ObjectWork::TYPE_RECREATION => 5, ...])
     *          ('arrangement' =>  @see ArrangementModelFacade)
     * @return ArrangementModelFacade
     * @throws \yii\db\Exception
     */
    public function generateTerritoryArrangement(string $generateType, int $territoryId, int $addGenType = self::OPTIONS_DEFAULT, int $templateId = null, array $params = [])
    {
        $this->manager->setTerritory($generateType, $territoryId, array_key_exists('votes', $params) ? $params['votes'] : []);

        if ($templateId) {
            $this->manager->template->generateTemplateMatrix($templateId,  count($this->manager->territory->matrix[0]), count($this->manager->territory->matrix));
        }

        $referenceUnitCost = null;
        $referenceEmptyCells = null;
        if ($addGenType == self::OPTIONS_BUDGET_ECONOMY) {
            $endFlag = true;
            while (!$this->manager->isFilled() && $endFlag) {
                $endFlag = $this->manager->setSuitableObject();
            }

            $referenceUnitCost = $this->manager->territory->calculateUnitCost();
            $referenceEmptyCells = $this->manager->territory->calculateEmptyCells();

            $this->manager->setTerritory($generateType, $territoryId, array_key_exists('votes', $params) ? $params['votes'] : []);
        }

        $endFlag = true;

        while (!$this->manager->isFilled() && $endFlag) {
            $endFlag = $this->manager->setSuitableObject($addGenType, $referenceUnitCost, $referenceEmptyCells,
                array_key_exists('arrangement', $params) ? $params['arrangement'] : [], $templateId);
        }

        $this->model = new ArrangementModelFacade($this->manager->territory->matrix, $this->manager->territory->state->objectIds, $this->manager->territory->state->objectsList);

        return $this->model;
    }

    /**
     * Корректирует расстановку площадки
     * @param int $fullness тип наполненности площадки
     * @param array $params список дополнительных параметров
     *          ('originalFullness' => float) - уровень заполненности оригинальной площадки
     * @throws Exception
     */
    public function correctArrangement($fullness = TerritoryConcept::TYPE_FULLNESS_MID, $params = [])
    {
        if (!isset($this->model)) {
            throw new Exception('Невозможно скорректировать расстановку. Расстановка не задана');
        }

        $this->manager->correctArrangement($fullness, $params);
        $this->model = new ArrangementModelFacade($this->manager->territory->matrix, $this->manager->territory->state->objectIds, $this->manager->territory->state->objectsList);
    }

    public function assemblyFixedArrangementByTerritoryId($territoryId)
    {
        $this->prepare($territoryId);

        $objects = FixedArrangementWork::find()->where(['territory_id' => $territoryId])->all();

        foreach ($objects as $object) {
            /** @var FixedArrangementWork $object */
            switch ($object->position) {
                case TerritoryConcept::HORIZONTAL_POSITION:
                    $this->manager->territory->installHorizontalObject($object->objectWork, $object->left, $object->top);
                    break;
                case TerritoryConcept::VERTICAL_POSITION:
                    $this->manager->territory->installVerticalObject($object->objectWork, $object->left, $object->top);
                    break;
                default:
                    throw new \Exception('Неизвестный тип позиционирования');
            }

            $this->manager->territory->state->addToObjectIds($object->object_id);
            $this->manager->territory->state->addToObjectsList($object->objectWork, $object->left, $object->top, $object->position);
        }

        $this->model = new ArrangementModelFacade($this->manager->territory->matrix, $this->manager->territory->state->objectIds, $this->manager->territory->state->objectsList);
        return $this->model;
    }

    /**
     * Установка объекта в заданную позицию
     * @param int $territoryId id территории
     * @param $object @see ObjectWork
     * @param int $left отступ от левого края
     * @param int $top отступ от верхнего края
     * @param int $position позиционирование объекта: TerritoryConcept::HORIZONTAL_POSITION / TerritoryConcept::VERTICAL_POSITION
     */
    public function installObject($territoryId, $object, $left, $top, $position)
    {
        if (!isset($this->model)) {
            $this->prepare($territoryId);
        }

        $this->manager->installObject($object, $left, $top, $position);
        $this->model->setMatrix($this->manager->territory->matrix);
        $this->model->setObjectsCount($this->manager->territory->state->objectIds);
        $this->model->setObjectsList($this->manager->territory->state->objectsList);
    }

    /**
     * Удаление объекта из заданной позиции
     * @param $object @see ObjectWork
     * @param int $left отступ от левого края
     * @param int $top отступ от верхнего края
     * @param int $position позиционирование объекта: TerritoryConcept::HORIZONTAL_POSITION / TerritoryConcept::VERTICAL_POSITION
     */
    public function removeObject($object, $left, $top, $position)
    {
        $this->manager->removeObject($object, $left, $top, $position);
        $this->model->setMatrix($this->manager->territory->matrix);
        $this->model->setObjectsCount($this->manager->territory->state->objectIds);
        $this->model->setObjectsList($this->manager->territory->state->objectsList);
    }

    /**
     * Возвращает матрицу в сыром виде
     * @return array
     */
    public function getRawMatrix()
    {
        return $this->model->getRawMatrix();
    }

    /**
     * Возвращает список объектов с позиционированием
     * @return array
     */
    public function getObjectsPosition()
    {
        return $this->model->getObjectsList();
    }

    /**
     * Возвращает список объектов с количеством
     * @return array
     */
    public function getObjectsCount()
    {
        return $this->model->getObjectsCount();
    }

    public function getAnalyticData()
    {
        return $this->model->getAnalyticData();
    }
}