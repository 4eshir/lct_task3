<?php

use yii\db\Migration;

/**
 * Class m240502_095106_add_age_interval
 */
class m240502_095106_add_age_interval extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ages_interval', [
            'id' => $this->primaryKey(),
            'left_age' => $this->integer(),
            'right_age' => $this->integer(),
        ]);

        $this->insert('ages_interval', [
            'id' => 1,
            'left_age' => 0,
            'right_age' => 4,
        ]);

        $this->insert('ages_interval', [
            'id' => 2,
            'left_age' => 5,
            'right_age' => 9,
        ]);

        $this->insert('ages_interval', [
            'id' => 3,
            'left_age' => 10,
            'right_age' => 18,
        ]);

        $this->insert('ages_interval', [
            'id' => 4,
            'left_age' => 19,
            'right_age' => 25,
        ]);

        $this->insert('ages_interval', [
            'id' => 5,
            'left_age' => 26,
            'right_age' => 35,
        ]);

        $this->insert('ages_interval', [
            'id' => 6,
            'left_age' => 36,
            'right_age' => 55,
        ]);

        $this->insert('ages_interval', [
            'id' => 7,
            'left_age' => 56,
            'right_age' => 130,
        ]);


        $this->addColumn('ages', 'ages_interval_id', $this->integer()->null());

        $this->update('ages', ['ages_interval_id' => 1], ['left_age' => 0]);
        $this->update('ages', ['ages_interval_id' => 2], ['left_age' => 5]);
        $this->update('ages', ['ages_interval_id' => 3], ['left_age' => 10]);
        $this->update('ages', ['ages_interval_id' => 4], ['left_age' => 19]);
        $this->update('ages', ['ages_interval_id' => 5], ['left_age' => 26]);
        $this->update('ages', ['ages_interval_id' => 6], ['left_age' => 36]);
        $this->update('ages', ['ages_interval_id' => 7], ['left_age' => 55]);

        $this->dropColumn('ages', 'left_age');
        $this->dropColumn('ages', 'right_age');


        $this->addColumn('ages_weight', 'ages_interval_id', $this->integer()->null());

        $this->update('ages_weight', ['ages_interval_id' => 1], ['left_age' => 0]);
        $this->update('ages_weight', ['ages_interval_id' => 2], ['left_age' => 5]);
        $this->update('ages_weight', ['ages_interval_id' => 3], ['left_age' => 10]);
        $this->update('ages_weight', ['ages_interval_id' => 4], ['left_age' => 19]);
        $this->update('ages_weight', ['ages_interval_id' => 5], ['left_age' => 26]);
        $this->update('ages_weight', ['ages_interval_id' => 6], ['left_age' => 36]);
        $this->update('ages_weight', ['ages_interval_id' => 7], ['left_age' => 55]);

        $this->dropColumn('ages_weight', 'left_age');
        $this->dropColumn('ages_weight', 'right_age');

        $this->addForeignKey('fk2-ages',
            'ages',
            'ages_interval_id',
            'ages_interval',
            'id',
            'RESTRICT',
            'RESTRICT');

        $this->addForeignKey('fk1-ages_weight',
            'ages_weight',
            'ages_interval_id',
            'ages_interval',
            'id',
            'RESTRICT',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240502_095106_add_age_interval cannot be reverted.\n";

        return false;
    }
}
