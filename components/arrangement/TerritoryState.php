<?php


namespace app\components\arrangement;


use app\models\ObjectExtended;
use app\models\work\ObjectWork;
use yii\db\Exception;

class TerritoryState
{
    /**
     * Количество "ячеек" под каждый из типов объектов
     */
    public $sportPart;
    public $gamePart;
    public $recreationPart;
    public $educationPart;

    public $fillSport;
    public $fillGame;
    public $fillRecreation;
    public $fillEducation;

    /** @var array формат [id => count] */
    public $objectIds = [];

    /** @var ObjectExtended[]  */
    public $objectsList = [];

    public function fill($recreationPart, $sportPart, $educationalPart, $gamePart)
    {
        $this->recreationPart = $recreationPart;
        $this->sportPart = $sportPart;
        $this->educationPart = $educationalPart;
        $this->gamePart = $gamePart;

        $this->fillSport = 0;
        $this->fillGame = 0;
        $this->fillRecreation = 0;
        $this->fillEducation = 0;
    }

    public function addSport($cells)
    {
        if ($this->fillSport + $cells > $this->sportPart) {
            throw new Exception('Недостаточно места для размещения объекта спортивного типа');
        }

        $this->fillSport += $cells;
    }

    public function addGame($cells)
    {
        if ($this->fillGame + $cells > $this->gamePart) {
            throw new Exception('Недостаточно места для размещения объекта игрового типа');
        }

        $this->fillGame += $cells;
    }

    public function addRecreation($cells)
    {
        if ($this->fillRecreation + $cells > $this->recreationPart) {
            throw new Exception('Недостаточно места для размещения объекта рекреационного типа');
        }

        $this->fillRecreation += $cells;
    }

    public function addEducation($cells)
    {
        if ($this->fillEducation + $cells > $this->educationPart) {
            throw new Exception('Недостаточно места для размещения объекта развивающего типа');
        }

        $this->fillEducation += $cells;
    }

    public function getSortedFillsDesc(array &$fills)
    {
        arsort($fills);
    }

    public function addToObjectIds($objectId)
    {
        if (!array_key_exists($objectId, $this->objectIds)) {
            $this->objectIds[$objectId] = 1;
        }
        else {
            $this->objectIds[$objectId] += 1;
        }
    }

    public function addToObjectsList($object, $left, $top, $position)
    {
        $this->objectsList[] = new ObjectExtended($object, $left, $top, $position);
    }

    public function deleteObjectById($objectId, $left, $top)
    {
        if ($this->objectIds[$objectId] - 1 == 0) {
            unset($this->objectIds[$objectId]);
        }
        else {
            $this->objectIds[$objectId] -= 1;
        }

        $unsetKey = null;
        foreach ($this->objectsList as $key => $object) {
            /** @var ObjectExtended $object */
            if ($object->object->id == $objectId && $object->left == $left && $object->top == $top) {
                $unsetKey = $key;
                break;
            }
        }

        if ($unsetKey !== null) {
            unset($this->objectsList[$unsetKey]);
        }
    }

    public function getDebugFill()
    {
        return [
            ObjectWork::TYPE_RECREATION => [$this->recreationPart, $this->fillRecreation],
            ObjectWork::TYPE_SPORT => [$this->sportPart, $this->fillSport],
            ObjectWork::TYPE_EDUCATION => [$this->educationPart, $this->fillEducation],
            ObjectWork::TYPE_GAME => [$this->gamePart, $this->fillGame],
        ];
    }
}