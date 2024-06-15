<?php

use yii\db\Migration;

/**
 * Class m240613_175614_fixed_arrangement
 */
class m240613_175614_fixed_arrangement extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('fixed_arrangement', [
            'id' => $this->primaryKey(),
            'territory_id' => $this->integer(),
            'object_id' => $this->integer(),
            'left' => $this->integer(),
            'top' => $this->integer(),
            'position' => $this->boolean()->comment('0 - горизонтальное, 1 - вертикальное'),
        ]);

        $this->addForeignKey('fk1-fixed_arrangement',
            'fixed_arrangement',
            'territory_id',
            'territory',
            'id',
            'RESTRICT',
            'RESTRICT');

        $this->addForeignKey('fk2-fixed_arrangement',
            'fixed_arrangement',
            'object_id',
            'object',
            'id',
            'RESTRICT',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk1-fixed_arrangement', 'fixed_arrangement');
        $this->dropForeignKey('fk2-fixed_arrangement', 'fixed_arrangement');

        $this->dropTable('fixed_arrangement');

        return true;
    }
}
