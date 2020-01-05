<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assessment}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m191222_124742_create_assessment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%assessment}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment("Пользователь"),//(users jadvali bn bog'lanadi)
            'ball' => $this->integer()->comment("Балл"),
            'date_cr' => $this->datetime()->comment("Дата создание"),
            'user_from' => $this->integer()->comment("От"),//(users jadvali bn bog'lanadi)
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-assessment-user_id}}',
            '{{%assessment}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-assessment-user_id}}',
            '{{%assessment}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_from`
        $this->createIndex(
            '{{%idx-assessment-user_from}}',
            '{{%assessment}}',
            'user_from'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-assessment-user_from}}',
            '{{%assessment}}',
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
            '{{%fk-assessment-user_id}}',
            '{{%assessment}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-assessment-user_id}}',
            '{{%assessment}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-assessment-user_from}}',
            '{{%assessment}}'
        );

        // drops index for column `user_from`
        $this->dropIndex(
            '{{%idx-assessment-user_from}}',
            '{{%assessment}}'
        );

        $this->dropTable('{{%assessment}}');
    }
}
