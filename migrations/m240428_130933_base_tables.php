<?php

use yii\db\Migration;

/**
 * Class m240428_130933_base_tables
 */
class m240428_130933_base_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('municipality', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128),
            'sport_tendency' => $this->smallInteger(),
            'game_tendency' => $this->smallInteger(),
            'education_tendency' => $this->smallInteger(),
            'recreation_tendency' => $this->smallInteger(),
        ]);

        $this->createTable('ages', [
            'id' => $this->primaryKey(),
            'left_age' => $this->integer(),
            'right_age' => $this->integer(),
            'count' => $this->integer(),
            'municipality_id' => $this->integer(),
        ]);

        $this->addForeignKey('fk1-ages',
            'ages',
            'municipality_id',
            'municipality',
            'id',
            'RESTRICT',
            'RESTRICT');

        $this->createTable('object_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128),
        ]);

        $this->createTable('territory', [
            'id' => $this->primaryKey(),
            'length' => $this->integer(),
            'width' => $this->integer(),
        ]);

        $this->createTable('restrict_object_territory', [
            'id' => $this->primaryKey(),
            'object_type_id' => $this->integer(),
            'territory_id' => $this->integer(),
        ]);

        $this->addForeignKey('fk1-restrict_object_territory',
            'restrict_object_territory',
            'object_type_id',
            'object_type',
            'id',
            'RESTRICT',
            'RESTRICT');

        $this->addForeignKey('fk2-restrict_object_territory',
            'restrict_object_territory',
            'territory_id',
            'territory',
            'id',
            'RESTRICT',
            'RESTRICT');

        $this->createTable('playground_type', [
            'id' => $this->primaryKey(),
            'sport_coef' => $this->float(),
            'game_coef' => $this->float(),
            'education_coef' => $this->float(),
            'recreation_coef' => $this->float(),
            'priority_ages_id' => $this->integer(),
        ]);

        $this->addForeignKey('fk1-playground_type',
            'playground_type',
            'priority_ages_id',
            'ages',
            'id',
            'RESTRICT',
            'RESTRICT');

        $this->createTable('playground', [
            'id' => $this->primaryKey(),
            'playground_type_id' => $this->integer(),
        ]);

        $this->addForeignKey('fk1-playground',
            'playground',
            'playground_type_id',
            'playground_type',
            'id',
            'RESTRICT',
            'RESTRICT');

        $this->createTable('object', [
            'id' => $this->primaryKey(),
            'name' => $this->string(256),
            'length' => $this->integer(),
            'width' => $this->integer(),
            'height' => $this->integer(),
            'cost' => $this->float(),
            'created_time' => $this->integer()->comment('Время изготовления в днях'),
            'install_time' => $this->integer()->comment('Время установки в днях'),
            'worker_count' => $this->integer(),
            'object_type_id' => $this->integer(),
            'creator' => $this->string(256),
        ]);

        $this->addForeignKey('fk1-object',
            'object',
            'object_type_id',
            'object_type',
            'id',
            'RESTRICT',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk1-ages', 'ages');
        $this->dropForeignKey('fk1-restrict_object_territory', 'restrict_object_territory');
        $this->dropForeignKey('fk2-restrict_object_territory', 'restrict_object_territory');
        $this->dropForeignKey('fk1-playground_type', 'playground_type');
        $this->dropForeignKey('fk1-playground', 'playground');
        $this->dropForeignKey('fk1-object', 'object');

        $this->dropTable('municipality');
        $this->dropTable('ages');
        $this->dropTable('object_type');
        $this->dropTable('territory');
        $this->dropTable('restrict_object_territory');
        $this->dropTable('playground_type');
        $this->dropTable('playground');
        $this->dropTable('object');

        return true;
    }
}
