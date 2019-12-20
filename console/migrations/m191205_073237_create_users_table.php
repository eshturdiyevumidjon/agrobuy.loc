<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%companies}}`
 */
class m191205_073237_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string(255)->comment("Логин"),
            'password' => $this->string(255)->comment("Пароль"),
            'fio' => $this->string(255)->comment("ФИО"),
            'avatar' => $this->text()->comment("Фото"),
            'phone' => $this->string(255)->comment("Телефон"),
            'type' => $this->integer()->comment("Тип"),
            'email' => $this->string(255)->comment("Эмаил"),
            'balans' => $this->float()->comment("Баланс"),
            'company_id' => $this->integer()->comment("Компания"),
            'chek_advertising' => $this->boolean()->comment("Виберыте реклами"),
            'date_cr' =>$this->datetime()->comment("Дата создания"),
            'access_token' => $this->string(255)->comment("Токен"),
            'expiret_at' => $this->integer(),

        ]);

        // creates index for column `company_id`
        $this->createIndex(
            '{{%idx-users-company_id}}',
            '{{%users}}',
            'company_id'
        );

        // add foreign key for table `{{%companies}}`
        $this->addForeignKey(
            '{{%fk-users-company_id}}',
            '{{%users}}',
            'company_id',
            '{{%companies}}',
            'id',
            'CASCADE'
        );

        $this->insert('users',array(
          'id'=>1,
          'fio'=>'Иванов Иван Иванович',
          'type'=>1,
          'date_cr'=>date('Y-m-d H:i:s'),
          'login'=>'admin',
          'password' => Yii::$app->security->generatePasswordHash('admin'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%companies}}`
        $this->dropForeignKey(
            '{{%fk-users-company_id}}',
            '{{%users}}'
        );

        // drops index for column `company_id`
        $this->dropIndex(
            '{{%idx-users-company_id}}',
            '{{%users}}'
        );

        $this->dropTable('{{%users}}');
    }
}
