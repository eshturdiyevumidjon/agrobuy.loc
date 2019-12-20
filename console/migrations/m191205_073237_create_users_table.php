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
            'access_token' => $this->string(255)->comment("Токен"),
            'expiret_at' => $this->integer(),

        ]);


        $this->insert('users',array(
          'id'=>1,
          'fio'=>'Иванов Иван Иванович',
          'type'=>1,
          'login'=>'admin',
          'password' => Yii::$app->security->generatePasswordHash('admin'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('{{%users}}');
    }
}
