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
            'avatar' => $this->string(255)->comment("Аватар"),
            'phone' => $this->string(255)->comment("Телефон"),
            'type' => $this->integer()->comment("Тип"),
            'email' => $this->string(255)->comment("Эмаил"),
            'balance' => $this->float()->defaultValue(0)->comment("Баланс"),
            'access_token' => $this->string(255)->comment("Токен"),
            'expiret_at' => $this->integer()->comment("Время окончание токена"),
            'user_number' =>$this->string(255)->comment("ID номер"),
            'instagram'=>$this->string(255)->comment("Instagram"),
            'facebook'=>$this->string(255)->comment("Facebook"),
            'telegram'=>$this->string(255)->comment("Telegram"),
            'birthday'=>$this->date()->comment("Дата рождение"),
            'company_name'=>$this->string(255)->comment("Название компании"),
            'company_files'=>$this->text()->comment("Файлы компании"),
            'legal_status'=>$this->integer()->comment("Юридический статус"),
            'inn'=>$this->string(255)->comment("ИНН"),
            'web_site'=>$this->string(255)->comment("Web Site"),
            'passport_serial_number'=>$this->string(255)->comment("Серия паспорта"),
            'passport_number'=>$this->string(255)->comment("Номер паспорта"),
            'passport_date'=>$this->string(255)->comment("Дата паспорта"),
            'passport_serial_number'=>$this->string(255)->comment("Серия паспорта"),
            'passport_issue'=>$this->text()->comment("Кем выдан"),
            'passport_file'=>$this->string(255)->comment("Файл паспорта"),
            'check_phone'=>$this->boolean()->comment("Проверка телефона"),
            'check_mail'=>$this->boolean()->comment("Проверка почту"),
            'check_passport'=>$this->boolean()->comment("Проверка паспорта"),
            'check_car'=>$this->boolean()->comment("Проверка ьашины"),
            'code_for_phone'=>$this->string(255)->comment("Смс код"),
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
