<?php

namespace app\models\work;

use app\models\common\FixedArrangement;

class FixedArrangementWork extends FixedArrangement
{
    public function getObjectWork()
    {
        return $this->hasOne(ObjectWork::class, ['id' => 'object_id']);
    }
}