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
            'user_id' => $this->integer()->comment("Пользователь"),//(users jadvali bilan bog'lanadi)
            'type' => $this->integer()->comment("Тип"),//(1 => Куплю , 2 => Продам)
            'title' => $this->string(255)->comment("Заголовок"),
            'images' => $this->text()->comment("Фотографии"),
            'category_id' => $this->integer()->comment("Категория"),//(Category jadvali bn bog'lanadi)
            'subcategory_id' => $this->integer()->comment("Субкатегория"),//(Subcategory jadvali bn boglanadi)
            'city_name' => $this->text()->comment("Город,регион"),
            'text' => $this->text()->comment("Текст объявлении"),
            'price' => $this->float()->comment("Цена"),// price agar ozgartirilgan bolsa eski qiymati shu polyaga yuklanadi
            'old_price' => $this->float()->comment("Старая цена"),
            'unit_price' => $this->string(255)->comment("Цена за единицу"),
            'treaty' => $this->boolean()->comment("Договорная"),
            'date_cr' => $this->date()->comment("Дата создание"),

        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-ads-user_id}}',
            '{{%ads}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-ads-user_id}}',
            '{{%ads}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-ads-user_id}}',
            '{{%ads}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-ads-user_id}}',
            '{{%ads}}'
        );

        $this->dropTable('{{%ads}}');
    }
}
