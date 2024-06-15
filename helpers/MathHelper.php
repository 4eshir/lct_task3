<?php

namespace app\helpers;

class MathHelper
{
    /* количество значимых голосов. на данный момент:
     * 1,2,3,4 и 7,8,9,10 - значимые голоса (которые влияют на изменение веса)
     * 5 и 6 - нейтральные голоса, не влияют на вес
     */
    const COUNT_RELEVANT_VOTES = 4;

    // расчет веса одного пункта положительного голоса
    public static function calcPosVoteWeight($mainWeight, $maxVotes)
    {
        return (1 - $mainWeight) / $maxVotes / self::COUNT_RELEVANT_VOTES;
    }

    // расчет веса одного пункта отрицательного голоса
    public static function calcNegVoteWeight($mainWeight, $maxVotes)
    {
        return $mainWeight / $maxVotes / self::COUNT_RELEVANT_VOTES;
    }

    /**
     * Функция нормирования списка значений
     * @param array $values Значения, которые необходимо нормировать
     * @param float $basis Базис, к которому нормируем
     * @param int $precision Точность для округления нормированных значений
     */
    public static function rationing(array $values, float $basis, int $precision = 2)
    {
        $sum = array_sum($values);
        $rateValues = [];
        foreach ($values as $value) {
            $rateValues[] = $sum == 0 ? 0 : round(($value / $sum) * $basis, $precision);
        }

        //корректировка нормирования
        $diff = array_sum($rateValues) - $basis;
        if ($diff > 0) {
            $maxValue = max($rateValues);
            $maxIndex = array_search($maxValue, $rateValues);
            $rateValues[$maxIndex] -= $diff;
        } elseif ($diff < 0) {
            $minValue = min($rateValues);
            $minIndex = array_search($minValue, $rateValues);
            $rateValues[$minIndex] += abs($diff);
        }

        return $rateValues;
    }
}