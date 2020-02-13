<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%deleting_history}}`.
 */
class m200213_090726_create_deleting_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%deleting_history}}', [
            'id' => $this->primaryKey(),
            'text' => $this->text()->comment('Текст'),
            'about' => $this->text()->comment('Информация о пользователя'),
            'date_cr' => $this->datetime()->comment('Дата создание'),
            'type' => $this->integer()->comment('Тип'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%deleting_history}}');
    }
}
