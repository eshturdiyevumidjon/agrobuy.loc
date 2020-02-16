<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news_slider}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%news}}`
 */
class m200215_081311_create_news_slider_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news_slider}}', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer()->comment('Новости'),
            'name' => $this->string(255)->comment('Наименование'),
            'image' => $this->string(255)->comment('Картинка'),
            'link' => $this->string(255)->comment('Ссылка'),
        ]);

        // creates index for column `news_id`
        $this->createIndex(
            '{{%idx-news_slider-news_id}}',
            '{{%news_slider}}',
            'news_id'
        );

        // add foreign key for table `{{%news}}`
        $this->addForeignKey(
            '{{%fk-news_slider-news_id}}',
            '{{%news_slider}}',
            'news_id',
            '{{%news}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%news}}`
        $this->dropForeignKey(
            '{{%fk-news_slider-news_id}}',
            '{{%news_slider}}'
        );

        // drops index for column `news_id`
        $this->dropIndex(
            '{{%idx-news_slider-news_id}}',
            '{{%news_slider}}'
        );

        $this->dropTable('{{%news_slider}}');
    }
}
