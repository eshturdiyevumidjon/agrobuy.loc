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
            'title' => $this->string(255)->comment("Заголовок"),
            'text' => $this->text()->comment("Текст"),
            'date' => $this->date()->comment("Дата"),
            'image' => $this->string(255)->comment("Фотография"),
        ]);
         $this->insert('{{%news}}',array(
            'title' => 'News title',
            'text' => 'News text News text News text News text News text News text News text News text News text News text News text News text News text News text News text',
            'image' => 'news1.jpg',
            'date'=>date('Y-m-d'),
        ));
        
        $this->insert('{{%news}}',array(
            'title' => 'News2 title',
            'text' => 'News2 tekst News2 tekstNews2 tekstNews2News2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 News2 tekst',
            'image' => 'news2.jpg',
            'date'=>date('Y-m-d'),
        ));

        $this->insert('{{%news}}',array(
            'title' => 'News3 title',
            'text' => 'News3 tekst News2 tekstNews2 tekstNews2News2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 News2 tekst',
            'image' => 'news3.jpg',
            'date'=>date('Y-m-d'),
        ));

        $this->insert('{{%news}}',array(
            'title' => 'News4 title',
            'text' => 'News4 tekst News2 tekstNews2 tekstNews2News2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 tekstNews2 News2 tekst',
            'image' => 'news4.jpg',
            'date'=>date('Y-m-d'),
        ));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }
}
