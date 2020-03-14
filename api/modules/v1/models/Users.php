<?php

namespace api\modules\v1\models;

use Yii;
use backend\base\AppActiveQuery;
use yii\behaviors\BlameableBehavior;
use yii\web\ForbiddenHttpException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use api\modules\v1\models\UsersBall;
use api\modules\v1\models\Chats;
use api\modules\v1\models\ChatUsers;
use api\modules\v1\models\UsersReyting;
use yii\db\Expression;


class Users extends \yii\db\ActiveRecord
{
    public $new_password;
    public $image;
    public $passport_image;
    public $company_image;
    public $step_validate;
    const EXPIRE_TIME = 3600 * 24 * 7;

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['type', 'expiret_at', 'legal_status', 'check_phone', 'check_mail', 'check_passport', 'check_car'], 'integer'],
            [['balance'], 'number'],
            [['birthday','step_validate'], 'safe'],
            [['email'], 'email'],
            ['password', 'required', 'when' => function($model) {return $this->isNewRecord;}, 'enableClientValidation' => false],
            [['image','new_password', 'passport_image', 'company_image'], 'safe'],
            [['company_files', 'passport_issue'], 'string'],
            [['login', 'password', 'fio', 'avatar', 'phone', 'email', 'access_token', 'user_number', 'instagram', 'facebook', 'telegram', 'company_name', 'inn', 'passport_serial_number', 'passport_number', 'passport_date', 'passport_file', 'code_for_phone', 'web_site'], 'string', 'max' => 255],
            // ['passport_serial_number', 'getPassportSeriaValidate'],
            ['passport_serial_number', 'getPassportSeriaValidate', 'when' => function($model) {return $this->step_validate == 3;}, 'enableClientValidation' => false],
            ['passport_number', 'getPassportNumberValidate', 'when' => function($model) {return $this->step_validate == 3;}, 'enableClientValidation' => false],
            ['passport_date', 'getPassportDateValidate', 'when' => function($model) {return $this->step_validate == 3;}, 'enableClientValidation' => false],
            ['inn', 'getInnValidate', 'when' => function($model) {return $this->step_validate == 4;}, 'enableClientValidation' => false],




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
            'avatar' => 'Аватар',
            'phone' => 'Телефон',
            'type' => 'Должность',
            'email' => Yii::t('app', 'E-mail'),
            'balance' =>'Баланс',
            'access_token' => Yii::t('app', 'Access Token'),
            'expiret_at' =>'Время окончание токена',
            'user_number' => 'ID номер',
            'instagram' => Yii::t('app', 'Instagram'),
            'facebook' => Yii::t('app', 'Facebook'),
            'telegram' => Yii::t('app', 'Telegram'),
            'birthday' =>'Дата рождение',
            'company_name' => 'Название компании',
            'company_files' => 'Файлы компании',
            'legal_status' =>'Юридический статус',
            'inn' => 'ИНН',
            'web_site' => Yii::t('app', 'Web Site'),
            'passport_serial_number' =>'Серия паспорта',
            'passport_number' =>'Номер паспорта',
            'passport_date' => 'Дата паспорта',
            'passport_issue' => 'Кем выдан',
            'passport_file' =>'Файл паспорта',
            'check_phone' =>'Проверка телефона',
            'check_mail' =>'Проверка почту',
            'check_passport' =>'Проверка паспорта',
            'check_car' =>'Проверка машины',
            'code_for_phone' => 'Смс код',
            'passport_image' => 'Картинка паспорта',
            'company_image' => 'Файлы компании',
        ];
    }


    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->balance = 0;
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            $this->access_token = Yii::$app->getSecurity()->generateRandomString();
            $this->expiret_at = time() + $this::EXPIRE_TIME;
        }

        if($this->new_password != null) $this->password = Yii::$app->security->generatePasswordHash($this->new_password);
        if($this->birthday != null) $this->birthday = date("Y-m-d", strtotime($this->birthday ));
        if($this->passport_date != null) $this->passport_date = date("Y-m-d", strtotime($this->passport_date ));
        
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert){
            if($this->type == 3){
                $chat = new Chats();
                $chat->name = 'chat_'.$this->id;
                $chat->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
                $chat->type = 1;
                $chat->save();

                $chat_1 = new ChatUsers();
                $chat_2 = new ChatUsers();
                
                $chat_1->chat_id = $chat->id;
                $chat_2->chat_id = $chat->id;
                $chat_1->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
                $chat_2->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
                $chat_1->user_id = 1;
                $chat_2->user_id = $this->id;

                $chat_1->save();
                $chat_2->save();
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }
    
    public function getAvatar()
    {
        if (!file_exists('uploads/avatars/'.$this->avatar) || $this->avatar == '') {
            $path = 'http://' . $_SERVER['SERVER_NAME'].'/admin/img/nouser.png';
        } else {
            $path = 'http://' . $_SERVER['SERVER_NAME'].'/admin/uploads/avatars/'.$this->avatar;
        }
        return $path;
    }

   

    public function beforeDelete()
    {
        return parent::beforeDelete();
    }


    public function getDate($date)
    {
        if($date != null) return date('d.m.Y', strtotime($date) );
        else $date;
    }


    public static function getType()
    {
        return [
            1 => "Администратор",
            2 => "Модератор",
            3 => "Пользователь",
        ];
    }


    public static function getTypeEdu()
    {
        return [
            1 => "Администратор",
            2 => "Модератор",
            3 => "Пользователь",
        ];
    }

    public function getTypeDescription()
    {
        switch ($this->type) {
            case 1: return "Администратор";
            case 2: return "Модератор";
            case 3: return "Пользователь";
            default: return "Неизвестно";
        }
    }

    public static function getPerDescription($type = null)
    {
        switch ($type) {
            case 1: return "Администратор";
            case 2: return "Модератор";
            case 3: return "Пользователь";
            default: return "Неизвестно";
        }
    }

    public static function getLegal()
    {
        return [
            1 => "Физ. лицо",
            2 => "ИП или Юр. лицо",
        ];
    }

    public function getPromotions()
    {
        return UsersPromotion::find()->where(['user_id' => $this->id])->all();
    }

    public function getHistories()
    {
        return HistoryOperations::find()->where(['user_id' => $this->id])->all();
    }

    // public function getAssessmentsList()
    // {
    //     return Assessment::find()->where(['user_id' => $this->id])->all();
    // }

    public function getStarCount()
    {
        $userBall = UsersBall::find()->where(['user_to' => $this->id])->all();
        $count = 0; $ball = 0;
        foreach ($userBall as $value) {
            $count++;
            $ball += $value->ball;
        }
        if($count > 0) return round($ball/$count, 2);
        else return 0;
    }

    public function getReyting()
    {
        $usersReyting = UsersReyting::find()->where(['user_id' => $this->id])->all();
        $reyting = 0;
        foreach ($usersReyting as $value) {
            $reyting += $value->ball;
        }
        return $reyting;
    }

    public function getAvatarForSite()
    {
        $siteName = Yii::$app->params['siteName'];

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/avatars/' . $this->avatar ) || $this->avatar == null) {
            $path = $siteName . '/backend/web/img/no-logo.png';
        } else {
            $path = $siteName . '/backend/web/uploads/avatars/' . $this->avatar;
        }
        return $path;
    }

    public function getPassportFile()
    {   
    	// ---------------file multi bolganda kerak bu
        // $siteName = Yii::$app->params['siteName'];
        // $files = explode(',',$this->passport_file);
        // $path = [];
        // foreach ($files as $key => $value) {
        //     if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/users/' . $value)) {
        //         $path [] = $siteName . '/backend/web/uploads/users/' . $value;
        //     } 
        // }
        // return $path;

        $siteName = Yii::$app->params['siteName'];

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/users/passports/' . $this->passport_file ) || $this->passport_file == null) {
            $path = $siteName . '/backend/web/img/no-logo.png';
        } else {
            $path = $siteName . '/backend/web/uploads/users/passports/' . $this->passport_file;
        }
        return $path;
    }

    public function getCompanyFiles()
    {   
        $siteName = Yii::$app->params['siteName'];

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/users/companies/' . $this->company_files ) || $this->company_files == null) {
            $path = $siteName . '/backend/web/img/no-logo.png';
        } else {
            $path = $siteName . '/backend/web/uploads/users/companies/' . $this->company_files;
        }
        return $path;
    }


    /*-------------------shartli ravishda saqlanish joyi fiksrlangan, keyinchalik o;zgarishi mumkin---------------------*/
    public function upload($path)
    {
        $fileName = $this->id.'_'. time() .'.'.$this->image->extension;
        $file = $path.'/backend/web/uploads/avatars/' . $fileName;
        if($this->image->saveAs($file)) {
            if(file_exists($path.'/backend/web/uploads/avatars/'.$this->avatar))
            {
                 unlink($path.'/backend/web/uploads/avatars/'.$this->avatar);
            }
            $this->avatar = $fileName;
            $this->save();
            return [$this->getAvatarForSite() ];
        }
    }

    /*shartli ravishda saqlanish joyi fiksrlangan, keyinchalik o;zgarishi mumkin*/
    public function uploadPassport($path)
    {   
        $fileName = $this->id.'_'. time() .'.'.$this->passport_image->extension;
        $file = $path.'/backend/web/uploads/users/passports/' . $fileName;
        if($this->passport_image->saveAs($file)) {
            if(file_exists($path.'/backend/web/uploads/users/passports/'.$this->passport_file))
            {
                 unlink($path.'/backend/web/uploads/users/passports/'.$this->passport_file);
            }
            $this->passport_file = $fileName;
            $this->save();
        }
    }

     /*shartli ravishda saqlanish joyi fiksrlangan, keyinchalik o;zgarishi mumkin*/
    public function uploadCompanyFiles($path)
    {   
        $fileName = $this->id.'_'. time() .'.'.$this->company_image->extension;
        $file = $path.'/backend/web/uploads/users/companies/' . $fileName;
        if($this->company_image->saveAs($file)) {
            if(file_exists($path.'/backend/web/uploads/users/companies/'.$this->company_files))
            {
                 unlink($path.'/backend/web/uploads/users/companies/'.$this->company_files);
            }
            $this->company_files = $fileName;
            $this->save();
        }
    }

    // registratsiyadan o'tgan userdan qaytadigan ma'lumot
    public function getUsersMinValues()
    {
         $result = [
            'userId' => $this->id,
            'avatar' => $this->getAvatarForSite(),
            'userType' => $this->type,
            'userTypeName' => $this->getTypeDescription(),
            'userFIO' => $this->fio,
            'userPhone' => $this->phone!=="" ? $this->phone : null,
            'access_token' => $this->access_token,
            'expiret_at' => $this->expiret_at,
            'login' => $this->login,
        ];
        return $result;
    }

     // Catalogdagi userning ma'lumotlari
    public function getUsersCatalog()
    {
         $result = [
            'userId' => $this->id,
            'avatar' => $this->getAvatarForSite(),
            'userFIO' => $this->fio,
            'company_name' => $this->company_name,
        ];
        return $result;
    }

    public function getUsersAllValues()
    {
         $result = [
            'userId' => $this->id,
            'fio' => $this->fio,
            'avatar' => $this->getAvatarForSite(),
            'birthday' => $this->birthday,
            'phone' => $this->phone,
            'email' => $this->email,
            'instagram' => $this->instagram,
            'facebook' => $this->facebook,
            'telegram' => $this->telegram,
            'web_site' => $this->web_site,
            'legal_status' => $this->legal_status,
            'passport_serial_number' => $this->passport_serial_number,
            'passport_number' => $this->passport_number,
            'passport_date' => $this->passport_date,
            'passport_issue' => $this->passport_issue,
            'passport_file' => $this->passport_file != null ? $this->getPassportFile() : [],
            'inn' => $this->inn,
            'company_name' => $this->company_name,
            'company_files' => $this->company_files != null ? $this->getCompanyFiles() : [],
        ];
        return $result;
    }
    public function getUsersPersonalValues()
    {
        $result = [
            'userId' => $this->id,
            'avatar' => $this->getAvatarForSite(),
            'fio' => $this->fio,
            'birthday' => $this->birthday,
            'phone' => $this->phone,
            'email' => $this->email,
            'instagram' => $this->instagram,
            'facebook' => $this->facebook,
            'telegram' => $this->telegram,
            'web_site' => $this->web_site,
        ];
        return $result;
    }

    public function getUserProfile()
    {
        $result = [
            'check_image' => $this->image != null ? true : false,
            'avatar' => $this->getAvatarForSite(),
            'check_fio' => $this->fio != null ? true : false,
            'fio' => $this->fio,
            'check_company_name' => $this->company_name != null ? true : false,
            'company_name' => $this->company_name,
            'check_phone'=> $this->phone != null ? true : false,
            'phone' => $this->phone,
            'check_email'=> $this->email != null ? true : false,
            'email' => $this->email,
            'check_passport' => $this->check_passport != null ? true : false,
            'check_car' => $this->check_car != null ? true : false,
            'check_instagram' => $this->instagram != null ? true : false,
            'instagram' => $this->instagram,
            'check_facebook'=> $this->facebook != null ? true : false,
            'facebook' => $this->facebook,
            'check_telegram'=> $this->telegram != null ? true : false,
            'telegram' => $this->telegram,
            'check_web_site'=> $this->web_site != null ? true : false,
            'web_site' => $this->web_site,
            'starCount' => (int)$this->getStarCount(),
            'reyting' => (int)$this->getReyting(),
        ];
        return $result;
    }

    public function getUsersStatusValues()
    {
        $result = [
            'legal_status' => $this->legal_status,
        ];
        return $result;
    }
    public function getUsersPassportValues()
    {
        $result = [
            'passport_serial_number' => $this->passport_serial_number,
            'passport_number' => $this->passport_number,
            'passport_date' => $this->passport_date,
            'passport_issue' => $this->passport_issue,
            'passport_file' => $this->passport_file != null ? $this->getPassportFile() : [],
        ];
        return $result;
    }

    //  -------------------userning yuridchiseyky malumotlari --------------------------
    public function getUsersYurPersonalValues()
    {
        $result = [
            'inn' => (int)$this->inn,
            'company_name' => $this->company_name,
            'company_files' => $this->getCompanyFiles(),
        ];
        return $result;
    }

    // ---------------------userning update oynasidagi reytingi---------------------------------
    public function UsersReyting()
    {
        $usersReyting = UsersReyting::find()
            ->select([new Expression('SUM(users_reyting.ball) as ball'), 'reyting_id',])
            ->joinWith(['reyting'])
            ->where(['user_id' => $this->id])
            ->groupBy('reyting_id')
            ->all();
        $array = []; $summ = 0;
        foreach ($usersReyting as $value) {
            $summ +=$value->ball;
            $array [] = [
                'reason_calculation' => $value->reyting->name,
                'calculation_formula' => '+' . $value->reyting->value . ' / ' . $value->reyting->value . ' ' . $value->reyting->getUnit()[$value->reyting->unit_id],
                'reyting' => $value->ball,
            ];
        }
        return [
            'reyting' => $array,
            'total' => $summ,
        ];
    }

    //  --------------------validatsiya pasport danniylar uchun----------------------------------
    public function getPassportSeriaValidate($attribute)
    {
        $passport_serial_number = $this->passport_serial_number;
        $strlen = strlen( $passport_serial_number );
        $numeric = 0; $char = "";
        for( $i = 0; $i <= $strlen; $i++ ) 
        {
            $char = substr( $passport_serial_number, $i, 1 );             
            if(ord($char) > 64 && ord($char) < 91) $numeric++;            
        }
        if($numeric != 2) $this->addError($attribute,'Вводите полностью полю «Серия паспорта»');
    }

    //  -------------------------------- passportni nomerini validatsiya qilish ---------------------
    public function getPassportNumberValidate($attribute)
    {
        $passport_number = $this->passport_number;
        $strlen = strlen( $passport_number );
        $numeric = 0; $char = "";
        for( $i = 0; $i <= $strlen; $i++ ) 
        {
            $char = substr( $passport_number, $i, 1 );             
            if(ord($char) > 47 && ord($char) < 58) $numeric++;            
        }
        if($numeric != 7) $this->addError($attribute,'Вводите полностью полю «Номер паспорта»');
    }

    // ---------------------- Passport date validatsiya qilish ------------------------
    public function getPassportDateValidate($attribute)
    { 
        $now = date('Y');
        $value = Yii::$app->formatter->asDate($this->passport_date, 'php:Y');
        if(($now - $value) > 10 || ($now - $value) < 0)
        $this->addError($attribute, 'Дата выдачи паспорта должна быть внутри ['.($now-10).', '.($now-0). ']');
    }

    // ----------------------Validatsiya INN--------------------------------------------
    public function getInnValidate()
    {
        $inn = $this->inn;
        $strlen = strlen( $inn );
        $numeric = 0; $char = "";
        for( $i = 0; $i <= $strlen; $i++ ) 
        {
            $char = substr( $inn, $i, 1 );             
            if(ord($char) > 47 && ord($char) < 58) $numeric++;            
        }
        if($numeric != 9) $this->addError($attribute,'Вводите полностью полю «Номер ИНН'); 
    }
}
