<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%for_register}}`.
 */
class m200209_151834_create_for_register_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%for_register}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string(255)->comment('Логин'),
            'phone' => $this->string(255)->comment('Телефон'),
            'password' => $this->string(255)->comment('Пароль'),
            'code' => $this->string(255)->comment('Временный код'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%for_register}}');
    }
}
