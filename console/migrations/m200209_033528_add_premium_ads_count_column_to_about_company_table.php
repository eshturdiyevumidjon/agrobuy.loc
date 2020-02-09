<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%about_company}}`.
 */
class m200209_033528_add_premium_ads_count_column_to_about_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%about_company}}', 'premium_ads_count', $this->integer()->defaultValue(50)->comment('Макс. кол-во премиум объявлении'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%about_company}}', 'premium_ads_count');
    }
}
