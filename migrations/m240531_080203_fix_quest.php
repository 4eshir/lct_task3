<?php

use yii\db\Migration;

/**
 * Class m240531_080203_fix_quest
 */
class m240531_080203_fix_quest extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('questionnaire', 'territory_id', $this->integer());

        $this->addForeignKey('fk3-questionnaire',
        'questionnaire',
        'territory_id',
        'territory',
        'id',
        'RESTRICT',
        'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk3-questionnaire', 'questionnaire');
        $this->dropColumn('questionnaire', 'territory_id');

        return true;
    }
}
