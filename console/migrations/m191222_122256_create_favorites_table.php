<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%favorites}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m191222_122256_create_favorites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%favorites}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment("Пользователь"),  
            'type' => $this->integer()->comment("Тип"),  
            'date_cr' => $this->datetime()->comment("Дата создание"),
            'field_id' => $this->string(255)->comment('Значение'),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-favorites-user_id}}',
            '{{%favorites}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-favorites-user_id}}',
            '{{%favorites}}',
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
            '{{%fk-favorites-user_id}}',
            '{{%favorites}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-favorites-user_id}}',
            '{{%favorites}}'
        );

        $this->dropTable('{{%favorites}}');
    }
}
