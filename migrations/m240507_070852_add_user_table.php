<?php

use yii\db\Migration;

/**
 * Class m240507_070852_add_user_table
 */
class m240507_070852_add_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'auth_flag', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'auth_flag');

        return true;
    }
}
