<?php

use yii\db\Migration;

/**
 * Class m240604_185518_fix_ages
 */
class m240604_185518_fix_ages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('ages_interval', ['left_age' => 0, 'right_age' => 7], ['id' => 1]);
        $this->update('ages_interval', ['left_age' => 8, 'right_age' => 12], ['id' => 2]);
        $this->update('ages_interval', ['left_age' => 13, 'right_age' => 18], ['id' => 3]);
        $this->update('ages_interval', ['left_age' => 19, 'right_age' => 30], ['id' => 4]);
        $this->update('ages_interval', ['left_age' => 31, 'right_age' => 55], ['id' => 5]);
        $this->update('ages_interval', ['left_age' => 56, 'right_age' => 130], ['id' => 6]);

        $this->delete('ages_weight', ['id' => 7]);
        $this->delete('ages_weight_changeable', ['id' => 7]);
        $this->delete('people_territory', ['ages_interval_id' => 7]);
        $this->delete('ages', ['ages_interval_id' => 7]);
        $this->delete('ages_interval', ['id' => 7]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240604_185518_fix_ages cannot be reverted.\n";

        return false;
    }
}
