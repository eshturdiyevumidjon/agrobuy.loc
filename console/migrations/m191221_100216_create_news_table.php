<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m191221_100216_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'price' => $this->string(255)->comment("Заголовок"),
            'text' => $this->text()->comment("Текст"),
            'date' => $this->date()->comment("Дата"),
            'image' => $this->string(255)->comment("Фотография"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }
}
