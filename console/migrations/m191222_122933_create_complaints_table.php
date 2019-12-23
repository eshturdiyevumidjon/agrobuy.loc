<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%complaints}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%ads}}`
 * - `{{%users}}`
 */
class m191222_122933_create_complaints_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%complaints}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment("Пользователь"),
            'ads_id' => $this->integer()->comment("Объявление"),
            'text' => $this->text()->comment("Текст"),
            'date_cr' =>$this->datetime()->comment("Дата создание"),
            'user_from' => $this->integer()->comment("Кто отправил"),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-complaints-user_id}}',
            '{{%complaints}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-complaints-user_id}}',
            '{{%complaints}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `ads_id`
        $this->createIndex(
            '{{%idx-complaints-ads_id}}',
            '{{%complaints}}',
            'ads_id'
        );

        // add foreign key for table `{{%ads}}`
        $this->addForeignKey(
            '{{%fk-complaints-ads_id}}',
            '{{%complaints}}',
            'ads_id',
            '{{%ads}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_from`
        $this->createIndex(
            '{{%idx-complaints-user_from}}',
            '{{%complaints}}',
            'user_from'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-complaints-user_from}}',
            '{{%complaints}}',
            'user_from',
            '{{%users}}',
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
            '{{%fk-complaints-user_id}}',
            '{{%complaints}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-complaints-user_id}}',
            '{{%complaints}}'
        );

        // drops foreign key for table `{{%ads}}`
        $this->dropForeignKey(
            '{{%fk-complaints-ads_id}}',
            '{{%complaints}}'
        );

        // drops index for column `ads_id`
        $this->dropIndex(
            '{{%idx-complaints-ads_id}}',
            '{{%complaints}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-complaints-user_from}}',
            '{{%complaints}}'
        );

        // drops index for column `user_from`
        $this->dropIndex(
            '{{%idx-complaints-user_from}}',
            '{{%complaints}}'
        );

        $this->dropTable('{{%complaints}}');
    }
}
