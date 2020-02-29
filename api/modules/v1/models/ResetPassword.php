<?php

namespace api\modules\v1\models;

use Yii;
use yii\base\Model;
use api\modules\v1\models\Users;
/**
 * This is the model class for table "chats".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $date_cr Дата создание
 * @property int|null $type Тип чата
 *
 * @property ChatMessage[] $chatMessages
 * @property ChatUsers[] $chatUsers
 */
class ResetPassword extends Model
{
    public $phone;
    public $step;
    public $password;
    public $check_password;
    public $code;


    public function rules()
    {
        return [
            [['phone','step','password','check_password','code'], 'safe'],
            // [['phone'], 'required'],

            // step = 1 uchun validation .. parolni tiklash uchun
            ['phone', 'required', 'when' => function($model) {return $model->step == 1;}, 'enableClientValidation' => false],
            ['phone', 'getNumberValidate', 'when' => function($model) {return $model->step == 1;}, 'enableClientValidation' => false],

            // step = 2 uchun validation .. parolni tiklash uchun
            ['password', 'required', 'when' => function($model) {return $model->step == 2;}, 'enableClientValidation' => false],
            ['check_password', 'required', 'when' => function($model) {return $model->step == 2;}, 'enableClientValidation' => false],
            ['code', 'required', 'when' => function($model) {return $model->step == 2;}, 'enableClientValidation' => false],


            ['code', 'getCodeValidate', 'when' => function($model) {return $model->step == 2;}, 'enableClientValidation' => false],
            
            ['check_password', 'getPasswordValidate', 'when' => function($model) {return $model->step == 2;}, 'enableClientValidation' => false],
        ];
    }

  
    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
        ];
    }
    // Telefon nomerni validation qilish
    public function getNumberValidate($attribute)
    { 
        $user = Users::find()->where(['phone' => $this->phone])->one();
        if( $user == null )$this->addError($attribute, 'Этот номер не существует.');
    }
    // Jo'natilgan kodni tekshirish
    public function getCodeValidate($attribute)
    { 
        $user = Users::find()->where(['code_for_phone' => $this->code])->one();
        if( $user == null )$this->addError($attribute, 'Этот код не существует.');
    }
    // password yangilanilayotganda yangi passwordlar bir xilligini tekshirish
    public function getPasswordValidate($attribute) {
        if( $this->password != $this->check_password) {
            $this->addError($attribute, 'Пароли не совпадают.');
        }
    }
    // telefonni validation qilish
    public function getValidatePhone()
    {   
        $user = Users::find()->where(['phone' => $this->phone])->one();
            $user->code_for_phone = '123456';
            $user->save();
            $arr = [
            'code' => $user->code_for_phone, 
        ];
        return $arr;
    }
    // passwordni yangilash
    public function ResetPassword() {
        $user = Users::find()->where(['code_for_phone' => $this->code])->one();
        $user->code_for_phone = null;
        $user->password = $this->password;
        $user->password = Yii::$app->security->generatePasswordHash($this->password);
        $user->save();
        $arr = ['status' => true,];
        return $arr;
    }

}
