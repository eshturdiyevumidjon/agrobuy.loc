<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users;

/**
 * Signup form
 */
class PasswordForm extends Model
{
    public $code;
    public $password;
    public $new_password;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['code', 'required'],
            ['code', 'string',],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['new_password', 'required'],
            ['new_password', 'string', 'min' => 6],
            [['new_password', 'password'], 'validateParol'],
            [['code'], 'validateCode'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'code' => Yii::t('app',"Kodni kiriting"),
            'password' => Yii::t('app',"Yangi parol"),
            'new_password' => Yii::t('app',"Takroriy parol"),
        ];
    }

    public function validateParol($attribute)
    { 
        if($this->new_password != $this->password) $this->addError($attribute, '«Новый пароль» и «Повторный ввод пароля» не совпадают');        
    }

    public function validateCode($attribute)
    { 
        $user = Users::find()->where(['code_for_phone' => $this->code])->one();
        if($user == null) $this->addError($attribute, '«Код подверждении» не найдено');        
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function isFind()
    {
        if (!$this->validate()) {
            return null;
        }

        //if()
        
        $user = new Users();
        $user->login = $this->login;
        $user->phone = $this->phone;
        $user->type = 3;
        $user->password = $this->password;
        return $user->save();
    }

}
