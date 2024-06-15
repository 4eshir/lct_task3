<?php

use yii\db\Migration;

/**
 * Class m240516_185133_add_people_object
 */
class m240516_185133_add_people_object extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('people_territory', [
            'id' => $this->primaryKey(),
            'count' => $this->integer(),
            'ages_interval_id' => $this->integer(),
            'territory_id' => $this->integer(),
        ]);

        $this->addForeignKey('fk1-people_territory',
            'people_territory',
            'ages_interval_id',
            'ages_interval',
            'id',
            'RESTRICT',
            'RESTRICT');

        $this->addForeignKey('fk2-people_territory',
            'people_territory',
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
        $this->dropForeignKey('fk1-people_territory', 'people_territory');
        $this->dropForeignKey('fk2-people_territory', 'people_territory');

        $this->dropTable('people_territory');

        return true;
    }
}
