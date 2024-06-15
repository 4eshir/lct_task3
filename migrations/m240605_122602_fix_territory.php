<?php

use yii\db\Migration;

/**
 * Class m240605_122602_fix_territory
 */
class m240605_122602_fix_territory extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('territory', 'address', $this->string());
        $this->addColumn('territory', 'latitude', $this->double()->comment('Широта'));
        $this->addColumn('territory', 'longitude', $this->double()->comment('Долгота'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('territory', 'address');
        $this->dropColumn('territory', 'latitude');
        $this->dropColumn('territory', 'longitude');

        return true;
    }

}
