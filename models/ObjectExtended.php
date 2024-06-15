<?php


namespace app\models;


use app\models\work\ObjectWork;

class ObjectExtended
{
    public ObjectWork $object;
    public $left;
    public $top;
    public $positionType;

    public function __construct(ObjectWork $object, $left, $top, $positionType)
    {
        $this->object = $object;
        $this->left = $left;
        $this->top = $top;
        $this->positionType = $positionType;
    }
}