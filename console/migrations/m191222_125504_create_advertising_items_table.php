<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%advertising_items}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%advertising}}`
 */
class m191222_125504_create_advertising_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%advertising_items}}', [
            'id' => $this->primaryKey(),
            'advertising_id' => $this->integer()->comment("Рекламные баннеры"),//(advertisings jadvali bn bog'lanadi)
            'title' =>$this->string(255)->comment("Заголовок"),
            'text' =>$this->text()->comment("Текст"),
            'link' =>$this->string(255)->comment("Ссылка"),
            'type' =>$this->integer()->comment("Тип рекламы"),//(1 => Фотография, 2 => Видео)
            'file' =>$this->string(255)->comment("Файл"),
        ]);

        // creates index for column `advertising_id`
        $this->createIndex(
            '{{%idx-advertising_items-advertising_id}}',
            '{{%advertising_items}}',
            'advertising_id'
        );

        // add foreign key for table `{{%advertising}}`
        $this->addForeignKey(
            '{{%fk-advertising_items-advertising_id}}',
            '{{%advertising_items}}',
            'advertising_id',
            '{{%advertisings}}',
            'id',
            'CASCADE'
        );

        $this->insert('{{%advertising_items}}',array(
            'id' => 1,
            'advertising_id' => 1,
            'title' => 'IFrut - свежие продукты',
            'text' => 'Компания занимающаяся выращиванием высококачественных продуктов с 2009г.',
            'link' => 'google.com',
            'type' => 1,
            'file' => 'ifrut.png',
        ));

        $this->insert('{{%advertising_items}}',array(
            'id' => 2,
            'advertising_id' => 2,
            'title' => 'Реклама',
            'text' => 'Новости',
            'link' => 'google.com',
            'type' => 1,
            'file' => 'news.png',
        ));

        $this->insert('{{%advertising_items}}',array(
            'id' => 3,
            'advertising_id' => 3,
            'title' => 'Реклама',
            'text' => 'Поиск большой',
            'link' => 'google.com',
            'type' => 1,
            'file' => 'search1.png',
        ));

        $this->insert('{{%advertising_items}}',array(
            'id' => 4,
            'advertising_id' => 4,
            'title' => 'Реклама',
            'text' => 'Поиск маленький',
            'link' => 'google.com',
            'type' => 1,
            'file' => 'search2.png',
        ));

        $this->insert('{{%advertising_items}}',array(
            'id' => 5,
            'advertising_id' => 5,
            'title' => 'IFrut - свежие продукты',
            'text' => 'Компания занимающаяся выращиванием высококачественных продуктов с 2009г. Они занимаются поставки не только на местные рынки, но и на международные площадки',
            'link' => 'google.com',
            'type' => 1,
            'file' => 'main.png',
        ));

        $this->insert('{{%advertising_items}}',array(
            'id' => 6,
            'advertising_id' => 6,
            'title' => 'Реклама',
            'text' => 'В категории',
            'link' => 'google.com',
            'type' => 1,
            'file' => 'reklama.png',
        ));

        $this->insert('{{%advertising_items}}',array(
            'id' => 7,
            'advertising_id' => 7,
            'title' => 'Реклама',
            'text' => 'В типовых карточках',
            'link' => 'google.com',
            'type' => 1,
            'file' => 'card.png',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%advertising}}`
        $this->dropForeignKey(
            '{{%fk-advertising_items-advertising_id}}',
            '{{%advertising_items}}'
        );

        // drops index for column `advertising_id`
        $this->dropIndex(
            '{{%idx-advertising_items-advertising_id}}',
            '{{%advertising_items}}'
        );

        $this->dropTable('{{%advertising_items}}');
    }
}
