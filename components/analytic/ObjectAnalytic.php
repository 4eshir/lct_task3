<?php

namespace app\components\analytic;

use app\models\work\ObjectWork;
use yii\db\BatchQueryResult;

class ObjectAnalytic
{
    const SIMILAR_TYPE_FULL = 1; // поиск максимально похожих объектов
    const SIMILAR_TYPE_QUITE = 2; // поиск достаточно похожих объектов
    const SIMILAR_TYPE_SLIGHTLY = 3; // поиск немного похожих объектов


    public function findSimilarObjects($targetObject, $type)
    {
        $baseObjects = ObjectWork::find()->where(['object_type_id' => $targetObject->object_type_id])->andWhere(['!=', 'id', $targetObject->id])->each();
        $objectIds = [];

        switch ($type) {
            case self::SIMILAR_TYPE_FULL:
                $objectIds = $this->findSimilarFull($targetObject, $baseObjects);
                break;
            case self::SIMILAR_TYPE_QUITE:
                $objectIds = $this->findSimilarQuite($targetObject, $baseObjects);
                break;
            case self::SIMILAR_TYPE_SLIGHTLY:
                $objectIds = $this->findSimilarSlightly($targetObject, $baseObjects);
                break;
            default:
                throw new \yii\base\Exception('Неизвестный тип поиска схожих объектов');
        }

        return ObjectWork::find()->where(['IN', 'id', $objectIds]);
    }

    /**
     * Функция поиска максимально схожих объектов
     * * Название совпадает на 70%
     * * Разброс по площади +-60%
     * * Разброс по стоимости +-30%
     * * Разброс по времени установки и времени создания +-50%
     * * Стили объектов совпадают
     * @param $targetObject
     * @param BatchQueryResult $objects итератор по исходному массиву объектов
     */
    private function findSimilarFull($targetObject, $objects)
    {
        $result = [];

        foreach ($objects as $object) {
            /** @var ObjectWork $object */

            if (
                $this->checkStringsDiff($targetObject->name, $object->name, 50) &&
                $this->checkNumbersDiff($targetObject->getSquare(), $object->getSquare(), 30) &&
                $this->checkNumbersDiff($targetObject->cost, $object->cost, 30) &&
                $this->checkNumbersDiff($targetObject->install_time, $object->install_time, 50) &&
                $this->checkNumbersDiff($targetObject->created_time, $object->created_time, 50) &&
                $this->checkStringsDiff($targetObject->style, $object->style, 100)
            ) {
                $result[] = $object->id;
            }
        }

        return $result;
    }

    /**
     * Функция поиска достаточно схожих объектов
     * * Название совпадает на 50%
     * * Разброс по площади +-80%
     * * Разброс по стоимости +-100%
     * * Разброс по времени установки и времени создания значения не имеют
     * * Стили объектов значения не имеют
     * @param $targetObject
     * @param BatchQueryResult $objects итератор по исходному массиву объектов
     */
    private function findSimilarQuite($targetObject, $objects)
    {
        $result = [];

        foreach ($objects as $object) {
            /** @var ObjectWork $object */
            if (
                $this->checkStringsDiff($targetObject->name, $object->name, 50) &&
                $this->checkNumbersDiff($targetObject->getSquare(), $object->getSquare(), 80) &&
                $this->checkNumbersDiff($targetObject->cost, $object->cost, 100)
            ) {
                $result[] = $object->id;
            }
        }

        return $result;
    }

    /**
     * Функция поиска немного схожих объектов
     * * Название совпадает на 30%
     * * Разброс по площади +-100%
     * * Разброс по стоимости +-200%
     * * Разброс по времени установки и времени создания значения не имеет
     * * Стили объектов значения не имеют
     * @param $targetObject
     * @param BatchQueryResult $objects итератор по исходному массиву объектов
     */
    private function findSimilarSlightly($targetObject, $objects)
    {
        $result = [];

        foreach ($objects as $object) {
            /** @var ObjectWork $object */
            if (
                $this->checkStringsDiff($targetObject->name, $object->name, 70) &&
                $this->checkNumbersDiff($targetObject->getSquare(), $object->getSquare(), 100) &&
                $this->checkNumbersDiff($targetObject->cost, $object->cost, 200)
            ) {
                $result[] = $object->id;
            }
        }

        return $result;
    }

    /**
     * Функция сравнения двух строк (алгоритм шинглов)
     * @param string $str1
     * @param string $str2
     * @param int $percent минимальный процент совпадения строк
     * @return bool
     */
    public function checkStringsDiff(string $str1, string $str2, int $percent)
    {
        $shingleCount = 3; // Количество символов в шингле (можно изменить по необходимости)

        $shingles1 = [];
        $shingles2 = [];

        // Создаем шинглы для первой строки
        for ($i = 0; $i <= strlen($str1) - $shingleCount; $i++) {
            $shingles1[] = substr($str1, $i, $shingleCount);
        }

        // Создаем шинглы для второй строки
        for ($i = 0; $i <= strlen($str2) - $shingleCount; $i++) {
            $shingles2[] = substr($str2, $i, $shingleCount);
        }

        // Подсчитываем количество общих шинглов
        $commonShingles = array_intersect($shingles1, $shingles2);
        $diffPercent = max(count($shingles1), count($shingles2)) !== 0 ? (1 - count($commonShingles) / max(count($shingles1), count($shingles2))) * 100 : 100;

        // Проверяем, превышено ли указанное различие в процентах
        return (100 - $diffPercent) > $percent;
    }

    public function checkStringsDiffT(string $str1, string $str2)
    {
        $shingleCount = 3; // Количество символов в шингле (можно изменить по необходимости)

        $shingles1 = [];
        $shingles2 = [];

        // Создаем шинглы для первой строки
        for ($i = 0; $i <= strlen($str1) - $shingleCount; $i++) {
            $shingles1[] = substr($str1, $i, $shingleCount);
        }

        // Создаем шинглы для второй строки
        for ($i = 0; $i <= strlen($str2) - $shingleCount; $i++) {
            $shingles2[] = substr($str2, $i, $shingleCount);
        }

        // Подсчитываем количество общих шинглов
        $commonShingles = array_intersect($shingles1, $shingles2);
        $diffPercent = max(count($shingles1), count($shingles2)) !== 0 ? (1 - count($commonShingles) / max(count($shingles1), count($shingles2))) * 100 : 100;

        // Проверяем, превышено ли указанное различие в процентах
        return $diffPercent;
    }

    /**
     * Функция сравнения двух чисел
     * @param int $numb1
     * @param int $numb2
     * @param int $percent максимальный процент расхождения чисел
     * @return bool
     */
    private function checkNumbersDiff(int $numb1, int $numb2, int $percent)
    {
        $diff = abs($numb1 - $numb2);
        $percentDiff = $numb2 !== 0 ? $diff / min($numb2, $numb1) * 100 : 0;

        return $percentDiff <= $percent;
    }
}