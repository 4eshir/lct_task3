<?php

use yii\db\Migration;

/**
 * Class m240530_073248_add_arrangement_table
 */
class m240530_073248_add_arrangement_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('arrangement', [
            'id' => $this->primaryKey(),
            'model' => $this->text(),
            'user_id' => $this->integer(),
            'generate_type' => $this->string()->comment('base - на базовых весах, change - на измененных весах, self - на основе голосов пользователя, manual - собрано вручную'),
            'datetime' => $this->date(),
            'territory_id' => $this->integer(),
        ]);

        $this->addForeignKey('fk1-arrangement',
            'arrangement',
            'user_id',
            'user',
            'id',
            'RESTRICT',
            'RESTRICT');

        $this->addForeignKey('fk2-arrangement',
            'arrangement',
            'territory_id',
            'territory',
            'id',
            'RESTRICT',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk1-arrangement', 'arrangement');
        $this->dropForeignKey('fk2-arrangement', 'arrangement');
        $this->dropTable('arrangement');

        return true;
    }
}
