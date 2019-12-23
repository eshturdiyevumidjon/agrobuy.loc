<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%settings}}`.
 */
class m191221_094017_create_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->string(255)->comment("Наименование"),
            'key' => $this->string(255)->comment("Ключ"),
            'text' => $this->text()->comment("Текст"),
            'priority' => $this->integer()->comment("Приоритет"),
            'view_in_footerser_id' => $this->boolean()->comment("Показать в футере"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%settings}}');
    }
}
