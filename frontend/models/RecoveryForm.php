<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users;

/**
 * Signup form
 */
class RecoveryForm extends Model
{
    public $phone;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            /*['login', 'trim'],
            ['login', 'required'],
            ['login', 'unique', 'targetClass' => '\common\models\Users', 'message' => Yii::t('app',"Ushbu login allaqachon band qilingan.") ],
            ['login', 'string', 'min' => 6, 'max' => 255],*/

            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone', 'string', 'max' => 255],
            [['phone'], 'validatePhone'],
        ];
    }

    public function attributeLabels()
    {
        return [
            //'login' => Yii::t('app',"Login"),
            //'password' => Yii::t('app',"Parol"),
            'phone' => Yii::t('app',"Telefon nomer"),
        ];
    }

    public function validatePhone($attribute)
    { 
        $user = Users::find()->where(['phone' => $this->phone])->one();
        if($user == null) $this->addError($attribute, '«Телефон номер» не найдено');        
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
        
        /*$user = new Users();
        $user->login = $this->login;
        $user->phone = $this->phone;
        $user->type = 3;
        $user->password = $this->password;
        return $user->save();*/
    }

}
