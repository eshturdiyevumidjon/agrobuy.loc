<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users;

/**
 * Signup form
 */
class CodeForm extends Model
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
            [['code'], 'validateCode'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'code' => Yii::t('app',"Kodni kiriting"),
        ];
    }

    /*public function validateParol($attribute)
    { 
        if($this->new_password != $this->password) $this->addError($attribute, '«Новый пароль» и «Повторный ввод пароля» не совпадают');        
    }*/

    public function validateCode($attribute)
    { 
        $user = Users::find()->where(['code_for_phone' => $this->code])->one();
        if($user == null) $this->addError($attribute, '«Код подверждении» не найдено');        
    }

}
