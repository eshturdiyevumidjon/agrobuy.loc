<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%ads}}`.
 */
class m200207_081500_add_status_column_to_ads_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%ads}}', 'status', $this->integer()->comment('Статус')->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%ads}}', 'status');
    }
}
