<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%companies}}`.
 */
class m191205_073101_create_companies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%companies}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Название компании"),
            'phone' => $this->string(255)->comment("Телефон"),
            'address' => $this->text()->comment("Адрес"),
            'logo' => $this->text()->comment("Лого"),
            'link' => $this->string(255)->comment("Линк"),
            'text' => $this->text()->comment("Текст"),
            'coordinate_x' => $this->string(255)->comment("Координата х"),
            'coordinate_y' => $this->string(255)->comment("Координата у"),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%companies}}');
    }
}
