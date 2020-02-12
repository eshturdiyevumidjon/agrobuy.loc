<?php

namespace api\modules\v1\models;

use Yii;

class ForRegister extends \yii\db\ActiveRecord
{
 
    public static function tableName()
    {
        return 'for_register';
    }


    public function rules()
    {
        return [
            [['login','password','phone','code'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'login' => 'Логин',
            'password' => 'Пароль',
            'phone' => 'Телефон',
            'code' => 'Код',
        ];
    }

}
