<?php

use yii\db\Migration;

/**
 * Class m240604_190556_correct_weights
 */
class m240604_190556_correct_weights extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('ages_weight', ['sport_weight' => 0.1, 'game_weight' => 0.6, 'education_weight' => 0.8, 'recreation_weight' => 0.1], ['id' => 1]);
        $this->update('ages_weight', ['sport_weight' => 0.3, 'game_weight' => 0.6, 'education_weight' => 0.3, 'recreation_weight' => 0.3], ['id' => 2]);
        $this->update('ages_weight', ['sport_weight' => 0.9, 'game_weight' => 0.3, 'education_weight' => 0.1, 'recreation_weight' => 0.5], ['id' => 3]);
        $this->update('ages_weight', ['sport_weight' => 0.7, 'game_weight' => 0.2, 'education_weight' => 0.1, 'recreation_weight' => 0.7], ['id' => 4]);
        $this->update('ages_weight', ['sport_weight' => 0.4, 'game_weight' => 0.1, 'education_weight' => 0.1, 'recreation_weight' => 0.8], ['id' => 5]);
        $this->update('ages_weight', ['sport_weight' => 0.2, 'game_weight' => 0.1, 'education_weight' => 0.1, 'recreation_weight' => 0.9], ['id' => 6]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240604_190556_correct_weights cannot be reverted.\n";

        return false;
    }
}
