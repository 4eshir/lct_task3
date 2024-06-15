<?php

use yii\db\Migration;

/**
 * Class m240612_165608_change_territory
 */
class m240612_165608_change_territory extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('territory', 'priority_type', $this->integer()->comment('1 - рекреация, 2 - спорт, 3 - развивающая, 4 - игровая')->null());
        $this->addColumn('territory', 'priority_coef', $this->float()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('territory', 'priority_type');
        $this->dropColumn('territory', 'priority_coef');

        return true;
    }

}
