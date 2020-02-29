<?php

namespace api\modules\v1\models;

use Yii;
use yii\base\Model;
use api\modules\v1\models\ForRegister;
use api\modules\v1\models\Users;


class RegisterForm extends Model
{
    const EVENT_REGISTERED = 'event_registered';

    public $login;
    public $password;
    public $phone;

    public function rules()
    {
        return [
            [['login', 'password','phone'], 'required'],
            [['password','phone','login'], 'string', 'max' => 255],

            [['login'], 'unique', 'targetClass' => '\api\modules\v1\models\Users', 'message' => 'Это логин уже существует.'],

            ['phone', 'validatePhone'],

            [['phone'], 'unique', 'targetClass' => '\api\modules\v1\models\Users', 'message' => 'Это телефон номер уже существует.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
            'phone' => 'Телефон',

        ];
    }

    public function  validatePhone()
    {
        if(!(strpos($this->phone, '+9989') == 0 && strlen($this->phone) == 13)) {$this->addError($attribute, 'Неправильный номер');return;}

        for ($i=1; $i < 12; $i++) { 
        	if($this->phone[$i] < '0' || $this->phone[$i] > '9') {$this->addError($attribute, 'Неправильный номер');break;}
        }

    }



    public function validateAgree($attribute)
    { 
        if($this->agree != 1) $this->addError($attribute, 'Необходимо Ваше согласие');
    }


    public function register()
    {
        if($this->validate() === false){
            return null;
        }

        $for_register = new ForRegister();
        $for_register->login = $this->login;
        $for_register->phone = $this->phone;
        $for_register->password = $this->password;
        $for_register->code = 123456;
        // $for_register->code =  str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

        if($for_register->save()) {
            return true;
        }

        return null;
    }

}