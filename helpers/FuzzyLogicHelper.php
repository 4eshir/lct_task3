<?php


namespace app\helpers;


use app\models\FuzzyIntervals;

class FuzzyLogicHelper
{
    /**
     * Рассчитывает гарантированный отрезок внутри секции нечеткой логики
     * @param array $section формат: [x, y]
     * @param int $sectionType тип секции (начальная, конечная, средняя)
     */
    public static function calculateSafeInterval(array $section, $sectionType)
    {
        switch ($sectionType) {
            case FuzzyIntervals::INTERVAL_TYPE_START:
                return [$section[0], $section[1] * (1 - FuzzyIntervals::INTERVALS_PERCENT_OFFSET)];
            case FuzzyIntervals::INTERVAL_TYPE_END:
                return [$section[0] * (1 + FuzzyIntervals::INTERVALS_PERCENT_OFFSET), $section[1]];
            case FuzzyIntervals::INTERVAL_TYPE_MIDDLE:
                return [$section[0] * (1 + FuzzyIntervals::INTERVALS_PERCENT_OFFSET), $section[1] * (1 - FuzzyIntervals::INTERVALS_PERCENT_OFFSET)];
            default:
                return $section;
        }
    }
}