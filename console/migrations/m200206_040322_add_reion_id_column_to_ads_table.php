<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%ads}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%regions}}`
 * - `{{%districts}}`
 */
class m200206_040322_add_reion_id_column_to_ads_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%ads}}', 'region_id', $this->integer()->comment('Город'));
        $this->addColumn('{{%ads}}', 'district_id', $this->integer()->comment('Район'));

        // creates index for column `region_id`
        $this->createIndex(
            '{{%idx-ads-region_id}}',
            '{{%ads}}',
            'region_id'
        );

        // add foreign key for table `{{%regions}}`
        $this->addForeignKey(
            '{{%fk-ads-region_id}}',
            '{{%ads}}',
            'region_id',
            '{{%regions}}',
            'id',
            'CASCADE'
        );

        // creates index for column `district_id`
        $this->createIndex(
            '{{%idx-ads-district_id}}',
            '{{%ads}}',
            'district_id'
        );

        // add foreign key for table `{{%districts}}`
        $this->addForeignKey(
            '{{%fk-ads-district_id}}',
            '{{%ads}}',
            'district_id',
            '{{%districts}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%regions}}`
        $this->dropForeignKey(
            '{{%fk-ads-region_id}}',
            '{{%ads}}'
        );

        // drops index for column `region_id`
        $this->dropIndex(
            '{{%idx-ads-region_id}}',
            '{{%ads}}'
        );

        // drops foreign key for table `{{%districts}}`
        $this->dropForeignKey(
            '{{%fk-ads-district_id}}',
            '{{%ads}}'
        );

        // drops index for column `district_id`
        $this->dropIndex(
            '{{%idx-ads-district_id}}',
            '{{%ads}}'
        );

        $this->dropColumn('{{%ads}}', 'region_id');
        $this->dropColumn('{{%ads}}', 'district_id');
    }
}
