<?php

use yii\db\Migration;

/**
 * Class m240605_061358_fix_objects
 */
class m240605_061358_fix_objects extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('object', 'article', $this->string());
        $this->addColumn('object', 'left_age', $this->integer());
        $this->addColumn('object', 'right_age', $this->integer());

        $this->addColumn('municipality', 'territory_id', $this->integer());

        $this->createTable('neighboring_territory', [
            'id' => $this->primaryKey(),
            'territory_id' => $this->integer(),
            'neighboring_territory_id' => $this->integer(),
        ]);


        $this->addForeignKey('fk1-neighboring_territory',
            'neighboring_territory',
            'territory_id',
            'territory',
            'id',
            'RESTRICT',
            'RESTRICT');

        $this->addForeignKey('fk2-neighboring_territory',
            'neighboring_territory',
            'neighboring_territory_id',
            'territory',
            'id',
            'RESTRICT',
            'RESTRICT');

        $this->addForeignKey('fk1-municipality',
            'municipality',
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
        $this->dropColumn('object', 'article');
        $this->dropColumn('object', 'left_age');
        $this->dropColumn('object', 'right_age');

        $this->dropForeignKey('fk1-municipality', 'municipality');
        $this->dropColumn('municipality', 'territory_id');

        $this->dropForeignKey('fk1-neighboring_territory', 'neighboring_territory');
        $this->dropForeignKey('fk2-neighboring_territory', 'neighboring_territory');

        $this->dropTable('neighboring_territory');

        return true;
    }
}
