<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_reyting}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%reyting}}`
 */
class m200207_063459_create_users_reyting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_reyting}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment('Пользователь'),
            'reyting_id' => $this->integer()->comment('Рейтинг'),
            'date_cr' => $this->datetime()->comment('Дата создание'),
            'ball' => $this->float()->comment('Балл'),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-users_reyting-user_id}}',
            '{{%users_reyting}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users_reyting-user_id}}',
            '{{%users_reyting}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `reyting_id`
        $this->createIndex(
            '{{%idx-users_reyting-reyting_id}}',
            '{{%users_reyting}}',
            'reyting_id'
        );

        // add foreign key for table `{{%reyting}}`
        $this->addForeignKey(
            '{{%fk-users_reyting-reyting_id}}',
            '{{%users_reyting}}',
            'reyting_id',
            '{{%reyting}}',
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
            '{{%fk-users_reyting-user_id}}',
            '{{%users_reyting}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-users_reyting-user_id}}',
            '{{%users_reyting}}'
        );

        // drops foreign key for table `{{%reyting}}`
        $this->dropForeignKey(
            '{{%fk-users_reyting-reyting_id}}',
            '{{%users_reyting}}'
        );

        // drops index for column `reyting_id`
        $this->dropIndex(
            '{{%idx-users_reyting-reyting_id}}',
            '{{%users_reyting}}'
        );

        $this->dropTable('{{%users_reyting}}');
    }
}
