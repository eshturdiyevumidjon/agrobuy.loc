<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_ball}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%users}}`
 */
class m200201_132220_create_users_ball_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_ball}}', [
            'id' => $this->primaryKey(),
            'user_from' => $this->integer()->comment('От пользователя'),
            'user_to' => $this->integer()->comment('Пользователь'),
            'ball' => $this->float()->comment('Балл'),
            'date_cr' => $this->datetime()->comment('Дата создание'),
        ]);

        // creates index for column `user_from`
        $this->createIndex(
            '{{%idx-users_ball-user_from}}',
            '{{%users_ball}}',
            'user_from'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users_ball-user_from}}',
            '{{%users_ball}}',
            'user_from',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_to`
        $this->createIndex(
            '{{%idx-users_ball-user_to}}',
            '{{%users_ball}}',
            'user_to'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users_ball-user_to}}',
            '{{%users_ball}}',
            'user_to',
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
            '{{%fk-users_ball-user_from}}',
            '{{%users_ball}}'
        );

        // drops index for column `user_from`
        $this->dropIndex(
            '{{%idx-users_ball-user_from}}',
            '{{%users_ball}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-users_ball-user_to}}',
            '{{%users_ball}}'
        );

        // drops index for column `user_to`
        $this->dropIndex(
            '{{%idx-users_ball-user_to}}',
            '{{%users_ball}}'
        );

        $this->dropTable('{{%users_ball}}');
    }
}
