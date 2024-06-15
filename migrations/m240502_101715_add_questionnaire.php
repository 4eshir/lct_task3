<?php

use yii\db\Migration;

/**
 * Class m240502_101715_add_questionnaire
 */
class m240502_101715_add_questionnaire extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'login' => $this->string(),
            'municipality_id' => $this->integer(),
            'role' => $this->smallInteger()->comment('1 - житель, 2 - член администрации, 3 - бог'),
        ]);

        $this->addForeignKey('fk1-user',
            'user',
            'municipality_id',
            'municipality',
            'id',
            'RESTRICT',
            'RESTRICT');


        $this->createTable('questionnaire', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'ages_interval_id' => $this->integer(),
            'sport_tendency' => $this->smallInteger(),
            'recreation_tendency' => $this->smallInteger(),
            'game_tendency' => $this->smallInteger(),
            'education_tendency' => $this->smallInteger(),
            'arrangement_matrix' => $this->json()->null(),
        ]);

        $this->addForeignKey('fk1-questionnaire',
            'questionnaire',
            'user_id',
            'user',
            'id',
            'RESTRICT',
            'RESTRICT');

        $this->addForeignKey('fk2-questionnaire',
            'questionnaire',
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
        $this->dropTable('questionnaire');
        $this->dropTable('user');

        return true;
    }
}
