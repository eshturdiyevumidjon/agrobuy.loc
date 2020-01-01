<?php

use yii\db\Migration;

/**
 * Class m200101_143319_add_foreign_key_to_ads
 */
class m200101_143319_add_foreign_key_to_ads extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-ads-category_id}}',
            '{{%ads}}',
            'category_id'
        );

        // add foreign key for table `{{%category}}`
        $this->addForeignKey(
            '{{%fk-ads-category_id}}',
            '{{%ads}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );

        // creates index for column `subcategory_id`
        $this->createIndex(
            '{{%idx-ads-subcategory_id}}',
            '{{%ads}}',
            'subcategory_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-ads-subcategory_id}}',
            '{{%ads}}',
            'subcategory_id',
            '{{%subcategory}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            '{{%fk-ads-category_id}}',
            '{{%ads}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-ads-category_id}}',
            '{{%ads}}'
        );

         // drops foreign key for table `{{%subcategory}}`
        $this->dropForeignKey(
            '{{%fk-ads-subcategory_id}}',
            '{{%ads}}'
        );

        // drops index for column `subcategory_id`
        $this->dropIndex(
            '{{%idx-ads-subcategory_id}}',
            '{{%ads}}'
        );
    }
}
