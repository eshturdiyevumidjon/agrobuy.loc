<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news_sort}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%news}}`
 */
class m200215_081051_create_news_sort_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news_sort}}', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer()->comment('Новости'),
            'name' => $this->string(255)->comment('Название'),
            'sort_name' => $this->string(255)->comment('Сорт'),
            'weight' => $this->string(255)->comment('Вес плода'),
            'productivity' => $this->string(255)->comment('Урожайность'),
        ]);

        // creates index for column `news_id`
        $this->createIndex(
            '{{%idx-news_sort-news_id}}',
            '{{%news_sort}}',
            'news_id'
        );

        // add foreign key for table `{{%news}}`
        $this->addForeignKey(
            '{{%fk-news_sort-news_id}}',
            '{{%news_sort}}',
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
            '{{%fk-news_sort-news_id}}',
            '{{%news_sort}}'
        );

        // drops index for column `news_id`
        $this->dropIndex(
            '{{%idx-news_sort-news_id}}',
            '{{%news_sort}}'
        );

        $this->dropTable('{{%news_sort}}');
    }
}
