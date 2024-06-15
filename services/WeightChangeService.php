<?php

namespace app\services;

use app\helpers\MathHelper;
use app\models\work\AgesWeightChangeableWork;
use app\models\work\AgesWeightWork;

class WeightChangeService
{
    public function changeWeight($territoryId, $ageInterval, $targetCoef, $maxCountByAge, $vote)
    {
        $entity = AgesWeightChangeableWork::find()->where(['ages_interval_id' => $ageInterval])->one();
        if ($vote <= 4) {
            $this->negativeVote($entity, $targetCoef, $maxCountByAge, $vote);
        }

        if ($vote >= 7) {
            $this->positiveVote($entity, $targetCoef, $maxCountByAge, $vote);
        }

        $entity->save();
    }

    private function positiveVote(&$entity, $targetCoef, $maxCountByAge, $vote)
    {
        switch ($targetCoef) {
            case AgesWeightChangeableWork::SPORT_COEF:
                $entity->sport_weight += MathHelper::calcPosVoteWeight($entity->sport_weight, $maxCountByAge) * ($vote - 6);
                break;
            case AgesWeightChangeableWork::EDUCATIONAL_COEF:
                $entity->educational_weight += MathHelper::calcPosVoteWeight($entity->educational_weight, $maxCountByAge) * ($vote - 6);
                break;
            case AgesWeightChangeableWork::GAME_COEF:
                $entity->game_weight += MathHelper::calcPosVoteWeight($entity->game_weight, $maxCountByAge) * ($vote - 6);
                break;
            case AgesWeightChangeableWork::RECREATION_COEF:
                $entity->recreation_weight += MathHelper::calcPosVoteWeight($entity->recreation_weight, $maxCountByAge) * ($vote - 6);
                break;
        }
    }

    private function negativeVote(&$entity, $targetCoef, $maxCountByAge, $vote)
    {
        switch ($targetCoef) {
            case AgesWeightChangeableWork::SPORT_COEF:
                $entity->sport_weight += MathHelper::calcNegVoteWeight($entity->sport_weight, $maxCountByAge) * (5 - $vote);
                break;
            case AgesWeightChangeableWork::EDUCATIONAL_COEF:
                $entity->educational_weight += MathHelper::calcNegVoteWeight($entity->educational_weight, $maxCountByAge) * (5 - $vote);
                break;
            case AgesWeightChangeableWork::GAME_COEF:
                $entity->game_weight += MathHelper::calcNegVoteWeight($entity->game_weight, $maxCountByAge) * (5 - $vote);
                break;
            case AgesWeightChangeableWork::RECREATION_COEF:
                $entity->recreation_weight += MathHelper::calcNegVoteWeight($entity->recreation_weight, $maxCountByAge) * (5 - $vote);
                break;
        }
    }
}