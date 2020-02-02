<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%ads}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%currency}}`
 */
class m200202_090644_add_currency_column_to_ads_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%ads}}', 'currency_id', $this->integer()->comment('Валюта'));

        // creates index for column `currency_id`
        $this->createIndex(
            '{{%idx-ads-currency_id}}',
            '{{%ads}}',
            'currency_id'
        );

        // add foreign key for table `{{%currency}}`
        $this->addForeignKey(
            '{{%fk-ads-currency_id}}',
            '{{%ads}}',
            'currency_id',
            '{{%currency}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%currency}}`
        $this->dropForeignKey(
            '{{%fk-ads-currency_id}}',
            '{{%ads}}'
        );

        // drops index for column `currency_id`
        $this->dropIndex(
            '{{%idx-ads-currency_id}}',
            '{{%ads}}'
        );

        $this->dropColumn('{{%ads}}', 'currency_id');
    }
}
