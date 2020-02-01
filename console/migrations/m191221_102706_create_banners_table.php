<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banners}}`.
 */
class m191221_102706_create_banners_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banners}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->comment("Заголовок"),
            'text' => $this->text()->comment("Текст"),
            'image' => $this->string(255)->comment("Фотография"),
            'link' => $this->string(255)->comment("Ссылка"),
        ]);

        $this->insert('{{%banners}}',array(
            'title' => 'IFrut - свежие фрукты',
            'text' => 'Компания занимающаяся выращиванием высококачественных фруктов с 2009 г. Они занимаются поставки не только на местные рынки, но и на международные площадки.',
            'image' => 'banner1.jpg',
            'link' => 'http://agrobuy.uz/',
        ));
        
        $this->insert('{{%banners}}',array(
            'title' => 'IFrut - свежие фрукты',
            'text' => 'Компания занимающаяся выращиванием высококачественных фруктов с 2009 г. Они занимаются поставки не только на местные рынки, но и на международные площадки.',
            'image' => 'banner2.jpg',
            'link' => 'http://agrobuy.uz/',
        ));

        $this->insert('{{%banners}}',array(
            'title' => 'IFrut - свежие фрукты',
            'text' => 'Компания занимающаяся выращиванием высококачественных фруктов с 2009 г. Они занимаются поставки не только на местные рынки, но и на международные площадки.',
            'image' => 'banner3.jpg',
            'link' => 'http://agrobuy.uz/',
        ));

        $this->insert('{{%banners}}',array(
            'title' => 'IFrut - свежие фрукты',
            'text' => 'Компания занимающаяся выращиванием высококачественных фруктов с 2009 г. Они занимаются поставки не только на местные рынки, но и на международные площадки.',
            'image' => 'banner4.jpg',
            'link' => 'http://agrobuy.uz/',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%banners}}');
    }
}
