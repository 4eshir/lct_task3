<?php

use yii\db\Migration;

/**
 * Class m240501_160049_add_dead_zone
 */
class m240501_160049_add_dead_zone extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('object', 'dead_zone_size', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('object', 'dead_zone_size');

        return true;
    }
}
