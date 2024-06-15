<?php

use yii\db\Migration;

/**
 * Class m240508_064300_add_new_ages_weight
 */
class m240508_064300_add_new_ages_weight extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ages_weight_changeable', [
            'id' => $this->primaryKey(),
            'self_weight' => $this->float(),
            'sport_weight' => $this->float(),
            'game_weight' => $this->float(),
            'education_weight' => $this->float(),
            'recreation_weight' => $this->float(),
            'ages_interval_id' => $this->integer()->null(),
        ]);

        $this->addForeignKey('fk1-ages_weight_changeable',
            'ages_weight_changeable',
            'ages_interval_id',
            'ages_interval',
            'id',
            'RESTRICT',
            'RESTRICT');


        $this->insert('ages_weight_changeable', [
            'self_weight' => 0.8,
            'recreation_weight' => 0.1,
            'sport_weight' => 0.1,
            'education_weight' => 0.8,
            'game_weight' => 0.6,
            'ages_interval_id' => 1,
        ]);

        $this->insert('ages_weight_changeable', [
            'self_weight' => 0.6,
            'recreation_weight' => 0.3,
            'sport_weight' => 0.2,
            'education_weight' => 0.4,
            'game_weight' => 0.6,
            'ages_interval_id' => 2,
        ]);

        $this->insert('ages_weight_changeable', [
            'self_weight' => 0.5,
            'recreation_weight' => 0.5,
            'sport_weight' => 0.8,
            'education_weight' => 0.1,
            'game_weight' => 0.3,
            'ages_interval_id' => 3,
        ]);

        $this->insert('ages_weight_changeable', [
            'self_weight' => 0.5,
            'recreation_weight' => 0.6,
            'sport_weight' => 0.9,
            'education_weight' => 0.1,
            'game_weight' => 0.2,
            'ages_interval_id' => 4,
        ]);

        $this->insert('ages_weight_changeable', [
            'self_weight' => 0.5,
            'recreation_weight' => 0.6,
            'sport_weight' => 0.6,
            'education_weight' => 0.1,
            'game_weight' => 0.2,
            'ages_interval_id' => 5,
        ]);

        $this->insert('ages_weight_changeable', [
            'self_weight' => 0.6,
            'recreation_weight' => 0.8,
            'sport_weight' => 0.4,
            'education_weight' => 0.1,
            'game_weight' => 0.1,
            'ages_interval_id' => 6,
        ]);

        $this->insert('ages_weight_changeable', [
            'self_weight' => 0.8,
            'recreation_weight' => 0.9,
            'sport_weight' => 0.2,
            'education_weight' => 0.1,
            'game_weight' => 0.1,
            'ages_interval_id' => 7,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('ages_weight_changeable');

        return true;
    }
}
