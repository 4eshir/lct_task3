<?php

use yii\db\Migration;

/**
 * Class m240609_154113_add_arrangement_templates
 */
class m240609_154113_add_arrangement_templates extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('arrangement_template', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->string()
        ]);

        $this->createTable('template_block', [
            'id' => $this->primaryKey(),
            'top' => $this->integer(),
            'left' => $this->integer(),
            'width' => $this->integer()->comment('Процент от общей высоты площадки'),
            'length' => $this->integer()->comment('Процент от общей длины площадки'),
            'object_type_id' => $this->integer()->null()->comment('ID из таблицы object_type, если null - то строить нельзя'),
            'arrangement_template_id' => $this->integer()
        ]);

        $this->addForeignKey('fk1-template_block',
            'template_block',
            'object_type_id',
            'object_type',
            'id',
            'RESTRICT',
            'RESTRICT');

        $this->addForeignKey('fk2-template_block',
            'template_block',
            'arrangement_template_id',
            'arrangement_template',
            'id',
            'RESTRICT',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk1-template_block', 'template_block');
        $this->dropForeignKey('fk2-template_block', 'template_block');

        $this->dropTable('template_block');
        $this->dropTable('arrangement_template');

        return true;
    }

}
