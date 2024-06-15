<?php

namespace app\components\coordinates;

use app\components\arrangement\TerritoryConcept;
use app\models\ObjectExtended;
use app\models\work\ObjectWork;
use app\models\work\TerritoryWork;

class LocalCoordinatesManager
{
    public static function calculateLocalCoordinates($territory, $objectExt, $step = TerritoryConcept::STEP)
    {

        /** @var ObjectExtended $objectExt */
        /** @var TerritoryWork $territory */

        $length = $objectExt->positionType == TerritoryConcept::HORIZONTAL_POSITION ? $objectExt->object->length : $objectExt->object->width;
        $width = $objectExt->positionType == TerritoryConcept::HORIZONTAL_POSITION ? $objectExt->object->width : $objectExt->object->length;

        $centerTerritory = [
            'top' => intval(ObjectWork::convertDistanceToCells($territory->width, $step) / 2),
            'left' => intval(ObjectWork::convertDistanceToCells($territory->length, $step) / 2),
        ];

        $newObjCoord = [
            'y' => $centerTerritory['top'] - $objectExt->top,
            'x' => $objectExt->left - $centerTerritory['left'],
        ];

        return [
            'x' => $newObjCoord['x'] + intval(ObjectWork::convertDistanceToCells($length, $step) / 2),
            'y' => $newObjCoord['y'] - intval(ObjectWork::convertDistanceToCells($width, $step) / 2),
        ];
    }

    /**
     * Конвертер локальных координат МАФ в WGS84
     * @param array $localCoord ['x'] - окальные координаты по оси X, ['y'] - локальные координаты по оси Y
     * @param array $centerCoord ['latitude'] - wgs84 широта, ['longitude'] - wgs84 долгота
     * @return array пара значений широты и долготы ['latitude' => ..., 'longitude' => ...]
     */
    public static function convertLocalToWGS84($localCoord, $centerCoord)
    {
        $localCoord['x'] *= TerritoryConcept::STEP;
        $localCoord['y'] *= TerritoryConcept::STEP;

        $earthRadius = 6378137; // Радиус Земли в метрах
        $deltaLatitude = $localCoord['y'] / $earthRadius;
        $deltaLongitude = $localCoord['x'] / ($earthRadius * cos(pi() * $centerCoord['longitude'] / 180));

        $latitude = $centerCoord['latitude'] + ($deltaLatitude * 180 / pi());
        $longitude = $centerCoord['longitude'] + ($deltaLongitude * 180 / pi());

        return ['latitude' => $latitude, 'longitude' => $longitude];
    }
}