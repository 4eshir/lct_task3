<?php


namespace app\components\arrangement;


use app\models\FuzzyIntervals;
use app\models\ObjectExtended;
use app\models\work\ObjectWork;
use Yii;

class TerritoryConcept
{
    /**
     * Типы генерации пространства
     * base - генерация на основе базовых весов
     * change - генерация на основе измененных весов для территории
     * self - генерация на основе голосования человека
     */
    const TYPE_BASE_WEIGHTS = 'base';
    const TYPE_CHANGE_WEIGHTS = 'change';
    const TYPE_SELF_VOTES = 'self';
    const TYPE_MANUAL = 'manual';

    /**
     * Типы наполненности площадок
     * 0 - оригинальная наполненность (при наличии площадки-эталона)
     * 1 - максимальная наполненность (занято от 60% свободного пространства)
     * 2 - средняя наполненность (занято от 30% до 59% свободного пространства)
     * 3 - минимальная наполненность (занято менее 30%)
     * Проценты могут варьироваться, в зависимости от зон безопасности вокруг объектов
     */
    const TYPE_FULLNESS_ORIGINAL = 0;
    const TYPE_FULLNESS_MAX = 1;
    const TYPE_FULLNESS_MID = 2;
    const TYPE_FULLNESS_MIN = 3;

    const HORIZONTAL_POSITION = 0;
    const VERTICAL_POSITION = 1;
    const STEP = 50; // размер "ячейки" в сантиметрах

    public $lengthCellCount; // количество ячеек в длину

    public $widthCellCount; // количество ячеек в ширину

    public $matrix = []; // матрица размещения объектов

    public TerritoryState $state; //данные по территории

    /** @var array ['name' => [0, 2, 4, 6]]
     * @see FuzzyIntervals
     */
    public array $fullnessIntervals; //интервалы нечеткой логики для заполненности

    public function __construct(TerritoryState $state)
    {
        $this->state = $state;
        $this->fullnessIntervals['sport'] = new FuzzyIntervals();
        $this->fullnessIntervals['game'] = new FuzzyIntervals();
        $this->fullnessIntervals['recreation'] = new FuzzyIntervals();
        $this->fullnessIntervals['education'] = new FuzzyIntervals();
    }

    public static function make($length, $width, $step)
    {
        $entity = Yii::createObject(self::class);
        $entity->lengthCellCount = intdiv($length, $step);
        $entity->widthCellCount = intdiv($width, $step);
        $entity->matrix = array_fill(0, $entity->widthCellCount, array_fill(0, $entity->lengthCellCount, '0'));

        return $entity;
    }

    public static function getExceptedFullness($fullness)
    {
        switch ($fullness) {
            case self::TYPE_FULLNESS_ORIGINAL:
                return [];
            case self::TYPE_FULLNESS_MAX:
                return [0.6, 1];
            case self::TYPE_FULLNESS_MID:
                return [0.3, 0.59];
            case self::TYPE_FULLNESS_MIN:
                return [0, 0.29];
            default:
                return [0, 1];
        }
    }

    /**
     * @param array $points формат: ['name' => [0, 2, 4, 6], ...]
     * @return void
     */
    public function setFullnessIntervals(array $points)
    {
        $this->fullnessIntervals['sport']->createIntervals($points['sport']);
        $this->fullnessIntervals['game']->createIntervals($points['game']);
        $this->fullnessIntervals['recreation']->createIntervals($points['recreation']);
        $this->fullnessIntervals['education']->createIntervals($points['education']);
    }

    // left и top это позиционирование, аналогичное абсолютному в HTML (уже с шагом, т.к. берем из JS)
    public function installHorizontalObject(ObjectWork $object, $left, $top)
    {
        for ($i = $top; $i < $top + ObjectWork::convertDistanceToCells($object->width,self::STEP); $i++) {
            for ($j = $left; $j < $left + ObjectWork::convertDistanceToCells($object->length, self::STEP); $j++) {
                $this->matrix[$i][$j] = (string)$object->id;
            }
        }
    }

    // left и top это позиционирование, аналогичное абсолютному в HTML (уже с шагом, т.к. берем из JS)
    public function installVerticalObject(ObjectWork $object, $left, $top)
    {
        for ($i = $top; $i < $top + ObjectWork::convertDistanceToCells($object->length,self::STEP); $i++) {
            for ($j = $left; $j < $left + ObjectWork::convertDistanceToCells($object->width, self::STEP); $j++) {
                $this->matrix[$i][$j] = (string)$object->id;
            }
        }
    }

    public function getState()
    {
        return $this->state;
    }

    public function showDebugMatrix($stream)
    {
        for ($i = 0; $i < count($this->matrix); $i++) {
            for ($j = 0; $j < count($this->matrix[$i]); $j++) {
                fwrite($stream, $this->matrix[$i][$j].' ');
            }
            fwrite($stream, "\n");
        }

        fwrite($stream, "\n");
    }

    public function calculateUnitCost()
    {
        if (!is_array($this->matrix) || count($this->matrix) == 0) {
            return 0;
        }

        //$emptyCells = $this->calculateEmptyCells();
        $usefulCells = count($this->matrix) * count($this->matrix[0]);

        $sum = 0;
        foreach ($this->state->objectsList as $object) {
            /** @var ObjectExtended $object */
            $sum += $object->object->cost;
        }

        return $sum / $usefulCells;
    }

    public function calculateEmptyCells()
    {
        $counter = 0;
        for ($i = 0; $i < count($this->matrix); $i++) {
            for ($j = 0; $j < count($this->matrix[$i]); $j++) {
                if ($this->matrix[$i][$j] == 0) {
                    $counter++;
                }
            }
        }

        return $counter;
    }

    public function calculateCurrentFullness()
    {
        return ((count($this->matrix) * count($this->matrix[0])) - $this->calculateEmptyCells()) / (count($this->matrix) * count($this->matrix[0]));
    }
}