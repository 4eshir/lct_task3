<?php

namespace app\helpers;

use app\facades\ArrangementModelFacade;
use app\models\ObjectExtended;
use app\models\work\ObjectWork;
use bupy7\xml\constructor\XmlConstructor;

class XmlHelper
{
    public static function generateObjectsListFile($objectsList)
    {
        $xmlArray = [];

        foreach ($objectsList as $object) {
            /** @var ObjectWork $object */
            $xmlArray[] = [
                'tag' => 'object',
                'attributes' => [
                    'id' => $object->id,
                    'name' => $object->name,
                    'length' => $object->length,
                    'width' => $object->width,
                    'height' => $object->height,
                    'cost' => $object->cost,
                    'created_time' => $object->created_time,
                    'install_time' => $object->install_time,
                    'worker_count' => $object->worker_count,
                    'object_type' => $object->objectType->name,
                    'creator' => $object->creator,
                    'dead_zone_size' => $object->dead_zone_size,
                    'style' => $object->style,
                    'article' => $object->article,
                    'left_age' => $object->left_age,
                    'right_age' => $object->right_age,
                ]
            ];
        }

        $xml = new XmlConstructor();
        $in = [
            [
                'tag' => 'root',
                'elements' => [
                    [
                        'tag' => 'objects_list',
                        'elements' => $xmlArray,
                    ],
                ],
            ],
        ];
        return $xml->fromArray($in)->toOutput();
    }

    public static function generateArrangementFile(ArrangementModelFacade $facadeModel)
    {
        $objects = [];
        $rows = [];

        foreach ($facadeModel->objectsPosition as $object) {
            /** @var ObjectExtended $object */
            $objects[] = [
                'tag' => 'object',
                'attributes' => [
                    'id' => $object->object->id,
                    'name' => $object->object->name,
                    'length' => $object->object->length,
                    'width' => $object->object->width,
                    'height' => $object->object->height,
                    'top' => $object->top,
                    'left' => $object->left,
                ]
            ];
        }

        $matrix = $facadeModel->getRawMatrix();
        for ($i = 0; $i < count($matrix); $i++) {
            $tempRow = '';
            for ($j = 0; $j < count($matrix[$i]); $j++) {
                $tempRow .= $matrix[$i][$j] . ' ';
            }
            $rows[] = [
                'tag' => 'row',
                'content' => $tempRow,
            ];
        }

        $xml = new XmlConstructor();
        $in = [
            [
                'tag' => 'root',
                'elements' => [
                    [
                        'tag' => 'matrix',
                        'elements' => $rows,
                    ],
                    [
                        'tag' => 'objects_list',
                        'elements' => $objects,
                    ],
                ],
            ],
        ];

        return $xml->fromArray($in)->toOutput();
    }

}