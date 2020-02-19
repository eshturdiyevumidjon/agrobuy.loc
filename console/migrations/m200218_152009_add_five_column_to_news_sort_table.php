<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%news_sort}}`.
 */
class m200218_152009_add_five_column_to_news_sort_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%news_sort}}', 'five', $this->string(255)->comment('Five'));
        $this->addColumn('{{%news_sort}}', 'six', $this->string(255)->comment('Six'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%news_sort}}', 'five');
        $this->dropColumn('{{%news_sort}}', 'six');
    }
}
