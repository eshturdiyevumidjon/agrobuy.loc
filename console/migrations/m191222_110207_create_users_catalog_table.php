<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_catalog}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%ads}}`
 */
class m191222_110207_create_users_catalog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_catalog}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment("Пользователь"),
            'ads_id' => $this->integer()->comment("Объявление"),
            'date_cr'=>$this->datetime()->comment("Дата создание"),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-users_catalog-user_id}}',
            '{{%users_catalog}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users_catalog-user_id}}',
            '{{%users_catalog}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `ads_id`
        $this->createIndex(
            '{{%idx-users_catalog-ads_id}}',
            '{{%users_catalog}}',
            'ads_id'
        );

        // add foreign key for table `{{%ads}}`
        $this->addForeignKey(
            '{{%fk-users_catalog-ads_id}}',
            '{{%users_catalog}}',
            'ads_id',
            '{{%ads}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-users_catalog-user_id}}',
            '{{%users_catalog}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-users_catalog-user_id}}',
            '{{%users_catalog}}'
        );

        // drops foreign key for table `{{%ads}}`
        $this->dropForeignKey(
            '{{%fk-users_catalog-ads_id}}',
            '{{%users_catalog}}'
        );

        // drops index for column `ads_id`
        $this->dropIndex(
            '{{%idx-users_catalog-ads_id}}',
            '{{%users_catalog}}'
        );

        $this->dropTable('{{%users_catalog}}');
    }
}
