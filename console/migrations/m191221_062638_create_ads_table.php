<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ads}}`.
 */
class m191221_062638_create_ads_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ads}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment("Пользователь"),
            'type' => $this->integer()->comment("Тип"),
            'title' => $this->string(255)->comment("Заголовок"),
            'images' => $this->text()->comment("Фотографии"),
            'category_id' => $this->integer()->comment("Категория"),
            'subcategory_id' => $this->integer()->comment("Субкатегория"),
            'city_name' => $this->text()->comment("Город,регион"),
            'text' => $this->text()->comment("Текст объявлении"),
            'price' => $this->float()->comment("Цена"),
            'old_price' => $this->float()->comment("Старая цена"),
            'unit_price' => $this->string(255)->comment("Цена за единицу"),
            'treaty' => $this->boolean()->comment("Договорная"),
            'date_cr' => $this->date()->comment("Дата создание"),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ads}}');
    }
}
