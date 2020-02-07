<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reyting}}`.
 */
class m200207_055048_create_reyting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reyting}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment('Наименование'),
            'ball' => $this->float()->comment('Балл'),
            'key' => $this->string(255)->comment('Ключ'),
            'unit_id' => $this->integer()->comment('Единица'),
            'value' => $this->float()->comment('Причина'),
        ]);

        $this->insert('{{%reyting}}',array(
            'name' => 'Заполненность профиля',
            'ball' => 50,
            'key' => 'profile_fullness',
            'unit_id' => 1, // %
            'value' => 100,
        ));

        $this->insert('{{%reyting}}',array(
            'name' => 'Посещения сайта',
            'ball' => 1,
            'key' => 'visit_site',
            'unit_id' => 2, // день
            'value' => 1,
        ));

        $this->insert('{{%reyting}}',array(
            'name' => 'Создание объявления',
            'ball' => 1,
            'key' => 'create_ads',
            'unit_id' => 3, // штук
            'value' => 1,
        ));

        $this->insert('{{%reyting}}',array(
            'name' => 'Деньги потраченные на платформе',
            'ball' => 1,
            'key' => 'money_use',
            'unit_id' => 4, // сум
            'value' => 500,
        ));

        $this->insert('{{%reyting}}',array(
            'name' => 'Отзывы пользователя',
            'ball' => 1,
            'key' => 'user_reviews',
            'unit_id' => 3, // штук
            'value' => 1,
        ));

        $this->insert('{{%reyting}}',array(
            'name' => 'Рейтинг на численный в дни праздников',
            'ball' => 0,
            'key' => 'profile_fullness',
            'unit_id' => 3, // штук
            'value' => 1,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%reyting}}');
    }
}
