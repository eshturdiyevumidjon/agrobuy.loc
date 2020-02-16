<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%ads}}`.
 */
class m200216_080813_add_top_column_to_ads_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%ads}}', 'top', $this->boolean()->defaultValue(0)->comment('Топ'));
        $this->addColumn('{{%ads}}', 'top_date', $this->date()->comment('Дата топа'));
        $this->addColumn('{{%ads}}', 'premium', $this->boolean()->defaultValue(0)->comment('Премиум'));
        $this->addColumn('{{%ads}}', 'premium_date', $this->date()->comment('Дата премиума'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%ads}}', 'top');
        $this->dropColumn('{{%ads}}', 'top_date');
        $this->dropColumn('{{%ads}}', 'premium');
        $this->dropColumn('{{%ads}}', 'premium_date');
    }
}
