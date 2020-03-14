<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%about_company}}`.
 */
class m200307_051848_add_top_ads_count_column_to_about_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%about_company}}', 'top_ads_count', $this->integer()->defaultValue(6)->comment('Количество топ объявлении'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%about_company}}', 'top_ads_count');
    }
}
