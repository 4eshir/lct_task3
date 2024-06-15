<?php

use yii\db\Migration;

/**
 * Class m240603_191751_add_admin_user
 */
class m240603_191751_add_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user', 'municipality_id', $this->integer()->null());
        $this->addColumn('user', 'password_hash', $this->string());

        $this->insert('user', [
            'login' => 'admin',
            'role' => 3,
            'password_hash' => '919062b9ab9b81c54dd1e55d0481c1c0',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'password_hash');

        return true;
    }

}
