<?php

use yii\db\Migration;

/**
 * Class m240603_144223_fill_object
 */
class m240603_144223_fill_object extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->truncateTable('object');

        $this->addColumn('object', 'style', $this->string());
        $this->addColumn('object', 'model_path', $this->string());

        // -- Рекреационные объекты --
        $this->insert('object', [
            'id' => 1,
            'name' => 'Recreation 1',
            'length' => 180,
            'width' => 50,
            'height' => 46,
            'cost' => 1000,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 1,
            'creator' => 'Manufacturer 1',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 2,
            'name' => 'Recreation 2',
            'length' => 220,
            'width' => 180,
            'height' => 350,
            'cost' => 4000,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 1,
            'creator' => 'Manufacturer 1',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 3,
            'name' => 'Recreation 3',
            'length' => 60,
            'width' => 60,
            'height' => 50,
            'cost' => 750,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 1,
            'creator' => 'Manufacturer 1',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 4,
            'name' => 'Recreation 4',
            'length' => 230,
            'width' => 80,
            'height' => 85,
            'cost' => 1500,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 1,
            'creator' => 'Manufacturer 2',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 5,
            'name' => 'Recreation 5',
            'length' => 400,
            'width' => 130,
            'height' => 300,
            'cost' => 3250,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 1,
            'creator' => 'Manufacturer 2',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 6,
            'name' => 'Recreation 6',
            'length' => 300,
            'width' => 250,
            'height' => 70,
            'cost' => 2500,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 1,
            'creator' => 'Manufacturer 2',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 7,
            'name' => 'Recreation 7',
            'length' => 40,
            'width' => 40,
            'height' => 75,
            'cost' => 1250,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 1,
            'creator' => 'Manufacturer 3',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 8,
            'name' => 'Recreation 8',
            'length' => 55,
            'width' => 20,
            'height' => 187,
            'cost' => 750,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 1,
            'creator' => 'Manufacturer 3',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 9,
            'name' => 'Recreation 9',
            'length' => 300,
            'width' => 300,
            'height' => 400,
            'cost' => 3000,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 1,
            'creator' => 'Manufacturer 3',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        // -- Спортивные объекты --
        $this->insert('object', [
            'id' => 10,
            'name' => 'Sport 1',
            'length' => 380,
            'width' => 20,
            'height' => 170,
            'cost' => 1000,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 2,
            'creator' => 'Manufacturer 1',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 11,
            'name' => 'Sport 2',
            'length' => 260,
            'width' => 220,
            'height' => 340,
            'cost' => 4000,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 2,
            'creator' => 'Manufacturer 1',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 12,
            'name' => 'Sport 3',
            'length' => 1020,
            'width' => 375,
            'height' => 180,
            'cost' => 750,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 2,
            'creator' => 'Manufacturer 1',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 13,
            'name' => 'Sport 4',
            'length' => 274,
            'width' => 150,
            'height' => 85,
            'cost' => 1500,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 2,
            'creator' => 'Manufacturer 2',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 14,
            'name' => 'Sport 5',
            'length' => 105,
            'width' => 88,
            'height' => 194,
            'cost' => 3250,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 2,
            'creator' => 'Manufacturer 2',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 15,
            'name' => 'Sport 6',
            'length' => 150,
            'width' => 51,
            'height' => 121,
            'cost' => 2500,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 2,
            'creator' => 'Manufacturer 2',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 16,
            'name' => 'Sport 7',
            'length' => 141,
            'width' => 55,
            'height' => 159,
            'cost' => 1250,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 2,
            'creator' => 'Manufacturer 3',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 17,
            'name' => 'Sport 8',
            'length' => 1000,
            'width' => 310,
            'height' => 440,
            'cost' => 750,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 2,
            'creator' => 'Manufacturer 3',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 18,
            'name' => 'Sport 9',
            'length' => 160,
            'width' => 60,
            'height' => 75,
            'cost' => 3000,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 2,
            'creator' => 'Manufacturer 3',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 19,
            'name' => 'Sport 10',
            'length' => 3000,
            'width' => 1500,
            'height' => 4000,
            'cost' => 3000,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 2,
            'creator' => 'Manufacturer 3',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        // -- Развивающие объекты --
        $this->insert('object', [
            'id' => 20,
            'name' => 'Education 1',
            'length' => 260,
            'width' => 116,
            'height' => 80,
            'cost' => 1000,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 3,
            'creator' => 'Manufacturer 1',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 21,
            'name' => 'Education 2',
            'length' => 30,
            'width' => 140,
            'height' => 200,
            'cost' => 4000,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 3,
            'creator' => 'Manufacturer 1',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 22,
            'name' => 'Education 3',
            'length' => 147,
            'width' => 27,
            'height' => 200,
            'cost' => 750,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 3,
            'creator' => 'Manufacturer 1',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 23,
            'name' => 'Education 4',
            'length' => 115,
            'width' => 70,
            'height' => 95,
            'cost' => 1500,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 3,
            'creator' => 'Manufacturer 2',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 24,
            'name' => 'Education 5',
            'length' => 200,
            'width' => 200,
            'height' => 100,
            'cost' => 3250,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 3,
            'creator' => 'Manufacturer 2',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 25,
            'name' => 'Education 6',
            'length' => 300,
            'width' => 300,
            'height' => 50,
            'cost' => 2500,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 3,
            'creator' => 'Manufacturer 2',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 26,
            'name' => 'Education 7',
            'length' => 145,
            'width' => 145,
            'height' => 75,
            'cost' => 1250,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 3,
            'creator' => 'Manufacturer 3',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 27,
            'name' => 'Education 8',
            'length' => 200,
            'width' => 65,
            'height' => 150,
            'cost' => 750,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 3,
            'creator' => 'Manufacturer 3',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 28,
            'name' => 'Education 9',
            'length' => 120,
            'width' => 20,
            'height' => 120,
            'cost' => 3000,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 3,
            'creator' => 'Manufacturer 3',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        // -- Игровые объекты --
        $this->insert('object', [
            'id' => 29,
            'name' => 'Game 1',
            'length' => 80,
            'width' => 45,
            'height' => 70,
            'cost' => 1000,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 4,
            'creator' => 'Manufacturer 1',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 30,
            'name' => 'Game 2',
            'length' => 335,
            'width' => 260,
            'height' => 150,
            'cost' => 4000,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 4,
            'creator' => 'Manufacturer 1',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 31,
            'name' => 'Game 3',
            'length' => 390,
            'width' => 60,
            'height' => 75,
            'cost' => 750,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 4,
            'creator' => 'Manufacturer 1',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 32,
            'name' => 'Game 4',
            'length' => 705,
            'width' => 620,
            'height' => 400,
            'cost' => 1500,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 4,
            'creator' => 'Manufacturer 2',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 33,
            'name' => 'Game 5',
            'length' => 267,
            'width' => 251,
            'height' => 220,
            'cost' => 3250,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 4,
            'creator' => 'Manufacturer 2',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 34,
            'name' => 'Game 6',
            'length' => 1940,
            'width' => 780,
            'height' => 300,
            'cost' => 2500,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 4,
            'creator' => 'Manufacturer 2',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 35,
            'name' => 'Game 7',
            'length' => 260,
            'width' => 240,
            'height' => 440,
            'cost' => 1250,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 4,
            'creator' => 'Manufacturer 3',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 36,
            'name' => 'Game 8',
            'length' => 690,
            'width' => 150,
            'height' => 90,
            'cost' => 750,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 4,
            'creator' => 'Manufacturer 3',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 37,
            'name' => 'Game 9',
            'length' => 420,
            'width' => 220,
            'height' => 270,
            'cost' => 3000,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 4,
            'creator' => 'Manufacturer 3',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

        $this->insert('object', [
            'id' => 38,
            'name' => 'Game 10',
            'length' => 220,
            'width' => 190,
            'height' => 110,
            'cost' => 3000,
            'created_time' => 0,
            'install_time' => 0,
            'worker_count' => 0,
            'object_type_id' => 4,
            'creator' => 'Manufacturer 3',
            'dead_zone_size' => 0,
            'style' => 'default',
            'model_path' => '',
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('object');

        return true;
    }
}
