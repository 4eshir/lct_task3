<?php

namespace app\models\work;

use app\models\common\AgesWeightChangeable;

class AgesWeightChangeableWork extends AgesWeightChangeable
{
    const SPORT_COEF = 'sport';
    const GAME_COEF = 'game';
    const EDUCATIONAL_COEF = 'educational';
    const RECREATION_COEF = 'recreation';
}