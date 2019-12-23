<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%advertisings}}`.
 */
class m191221_102217_create_advertisings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%advertisings}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование"),
            'key' => $this->string(255)->comment("Ключ"),
        ]);

        $this->insert('advertisings',array(
            'id' => 1,
            'name' => 'Каталог пользователя',
            'key' => 'user_catalog',
        ));

         $this->insert('advertisings',array(
            'id' => 2,
            'name' => 'Новости',
            'key' => 'news',
        ));

          $this->insert('advertisings',array(
            'id' => 3,
            'name' => 'Поиск болшой',
            'key' => 'search_big',
        ));

           $this->insert('advertisings',array(
            'id' => 4,
            'name' => 'Поиск маленький',
            'key' => 'search_small',
        ));

            $this->insert('advertisings',array(
            'id' => 5,
            'name' => 'Главная',
            'key' => 'main',
        ));

             $this->insert('advertisings',array(
            'id' => 6,
            'name' => 'В категории',
            'key' => 'category',
        ));

              $this->insert('advertisings',array(
            'id' => 7,
            'name' => 'В типовых карточках',
            'key' => 'in_news_card',
        ));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%advertisings}}');
    }
}
