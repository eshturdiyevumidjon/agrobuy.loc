<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_promotion}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%promotions}}`
 */
class m191222_093854_create_users_promotion_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_promotion}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment("Пользователь"),
            'promotion_id' => $this->integer()->comment("Продвижение"),
            'access_date'=>$this->date()->comment("Срок окончание"),
            'date_cr'=>$this->date()->comment("Дата создание"),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-users_promotion-user_id}}',
            '{{%users_promotion}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users_promotion-user_id}}',
            '{{%users_promotion}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `promotion_id`
        $this->createIndex(
            '{{%idx-users_promotion-promotion_id}}',
            '{{%users_promotion}}',
            'promotion_id'
        );

        // add foreign key for table `{{%promotions}}`
        $this->addForeignKey(
            '{{%fk-users_promotion-promotion_id}}',
            '{{%users_promotion}}',
            'promotion_id',
            '{{%promotions}}',
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
            '{{%fk-users_promotion-user_id}}',
            '{{%users_promotion}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-users_promotion-user_id}}',
            '{{%users_promotion}}'
        );

        // drops foreign key for table `{{%promotions}}`
        $this->dropForeignKey(
            '{{%fk-users_promotion-promotion_id}}',
            '{{%users_promotion}}'
        );

        // drops index for column `promotion_id`
        $this->dropIndex(
            '{{%idx-users_promotion-promotion_id}}',
            '{{%users_promotion}}'
        );

        $this->dropTable('{{%users_promotion}}');
    }
}
