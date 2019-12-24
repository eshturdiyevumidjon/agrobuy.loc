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
            'title' => 'Banner1 title',
            'text' => 'Banner1 text Banner1 text Banner1 text Banner1 text Banner1 text Banner1 text Banner1 text Banner1 text Banner1 text Banner1 text Banner1 text Banner1 text Banner1 text Banner1 text Banner1 text',
            'image' => 'banner1.jpg',
            'link' => $this->string(255)->comment("Ссылка"),
        ));
        
        $this->insert('{{%banners}}',array(
            'title' => 'Banner2 title',
            'text' => 'Banner2 tekst Banner2 tekstBanner2 tekstBanner2Banner2 tekstBanner2 tekstBanner2 tekstBanner2 tekstBanner2 tekstBanner2 tekstBanner2 tekstBanner2 tekstBanner2 tekstBanner2 tekstBanner2 Banner2 tekst',
            'image' => 'banner2.jpg',
            'link' => $this->string(255)->comment("Ссылка"),
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
