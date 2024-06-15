<?php


namespace app\models;


use app\helpers\FuzzyLogicHelper;
use yii\db\Exception;

class FuzzyIntervals
{
    /** @var int смещение внутри интервалов в долях */
    const INTERVALS_PERCENT_OFFSET = 0.2;

    const INTERVAL_TYPE_START = 1;
    const INTERVAL_TYPE_MIDDLE = 2;
    const INTERVAL_TYPE_END = 3;

    /**
     * Массив интервалов для нечеткой логики
     * Пример:
     * Входные данные [0, 0.3, 0.5, 0.7, 1.0]
     * Интервалы из примера будут следующими: [[0, 0.3], [0.3, 0.5], [0.5, 0.7], [0.7, 1.0]]
     * @var array
     */
    public $intervals = [];

    public function createIntervals($data)
    {
        if (count($data) < 2) {
            throw new Exception('Недостаточно точек для создания секций');
        }

        $this->intervals = [];
        for ($i = 0; $i < count($data) - 1; $i++) {
            $this->intervals[] = [floor($data[$i]), floor($data[$i + 1])];
        }
    }

    public function belongToInterval($value)
    {
        for ($i = 0; $i < count($this->intervals); $i++) {
            if ($i == 0) {
                $intervalType = FuzzyIntervals::INTERVAL_TYPE_START;
            } else if ($i == count($this->intervals) - 1) {
                $intervalType = FuzzyIntervals::INTERVAL_TYPE_END;
            } else {
                $intervalType = FuzzyIntervals::INTERVAL_TYPE_MIDDLE;
            }

            $safeSection = FuzzyLogicHelper::calculateSafeInterval($this->intervals[$i], $intervalType);

            // если значение принадлежит интервалу
            if ($value >= $this->intervals[$i][0] && $value <= $this->intervals[$i][1]) {
                // если значение лежит в гарантированном интервале, то возвращаем этот интервал
                if ($value >= $safeSection[0] && $value <= $safeSection[1]) {
                    return [$i => $this->intervals[$i]];
                } else if ($value < $safeSection[0]) {
                    // здесь алгоритм присваивания значения к одному из граничных интервалов (если слева)
                    $randomChoice = mt_rand(0, 1);
                    return $randomChoice == 0 ?
                        [$i => $this->intervals[$i]] :
                        [$i => $this->intervals[$i - 1]];
                } else if ($value > $safeSection[1]) {
                    // здесь алгоритм присваивания значения к одному из граничных интервалов (если справа)
                    $randomChoice = mt_rand(0, 1);
                    return $randomChoice == 0 ?
                        [$i => $this->intervals[$i]] :
                        [$i => $this->intervals[$i + 1]];
                }
            }
        }

        return -1;
    }

    /**
     * Принадлежность к последнему интервалу
     * @return bool
     */
    public function belongToLastInterval($value)
    {
        return array_key_first($this->belongToInterval($value)) == count($this->intervals) - 1;
    }

    /**
     * Принадлежность к предпоследнему интервалу
     * @return bool
     */
    public function belongToLastButOneInterval($value)
    {
        return $this->belongToInterval($value) == count($this->intervals) - 2;
    }
}