<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%history_operations}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m191222_115717_create_history_operations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%history_operations}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment("Пользователь"),
            'type' => $this->integer()->comment("Тип"),
            'date_cr' => $this->datetime()->comment("Дата создание"),
            'field_id' => $this->string(255)->comment("№ объявление"),
            'summa' => $this->float()->comment("Сумма"),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-history_operations-user_id}}',
            '{{%history_operations}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-history_operations-user_id}}',
            '{{%history_operations}}',
            'user_id',
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
            '{{%fk-history_operations-user_id}}',
            '{{%history_operations}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-history_operations-user_id}}',
            '{{%history_operations}}'
        );

        $this->dropTable('{{%history_operations}}');
    }
}
