<?php

use yii\db\Migration;

/**
 * Class m240511_144253_fix_changeable_weights
 */
class m240511_144253_fix_changeable_weights extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ages_weight_changeable', 'territory_id', $this->integer()->null());

        $this->addForeignKey('fk2-ages_weight_changeable',
            'ages_weight_changeable',
            'territory_id',
            'territory',
            'id',
            'RESTRICT',
            'RESTRICT');

        $this->addColumn('territory', 'name', $this->string(128));

        $this->insert('territory', [
            'id' => 1,
            'name' => 'Area 1',
            'length' => '10000',
            'width' => '10000',
        ]);

        $this->insert('territory', [
            'id' => 2,
            'name' => 'Area 2',
            'length' => '5000',
            'width' => '15000',
        ]);

        $this->insert('territory', [
            'id' => 3,
            'name' => 'Area 3',
            'length' => '20000',
            'width' => '7000',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk2-ages_weight_changeable', 'ages_weight_changeable');
        $this->dropColumn('ages_weight_changeable', 'territory_id');

        $this->dropColumn('territory', 'name');
        $this->truncateTable('territory');

        return true;
    }
}
