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


class Users extends \yii\db\ActiveRecord
{
    public $new_password;
    public $image;
    public $passport_image;
    public $company_image;
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
            [['birthday'], 'safe'],
            [['email'], 'email'],
            ['password', 'required', 'when' => function($model) {return $this->isNewRecord;}, 'enableClientValidation' => false],
            [['image','new_password', 'passport_image', 'company_image'], 'safe'],
            [['company_files', 'passport_issue'], 'string'],
            [['login', 'password', 'fio', 'avatar', 'phone', 'email', 'access_token', 'user_number', 'instagram', 'facebook', 'telegram', 'company_name', 'inn', 'passport_serial_number', 'passport_number', 'passport_date', 'passport_file', 'code_for_phone', 'web_site'], 'string', 'max' => 255],
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

                $chat1 = new ChatUsers();
                $chat2 = new ChatUsers();
                
                $chat1->chat_id = $chat->id;
                $chat2->chat_id = $chat->id;
                $chat1->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
                $chat2->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
                $chat1->user_id = 1;
                $chat2->user_id = $this->id;

                $chat1->save();
                $chat2->save();
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

    /**
     * @return bool
     */

    public function beforeDelete()
    {
        return parent::beforeDelete();
    }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getAds()
    // {
    //     return $this->hasMany(Ads::className(), ['user_id' => 'id']);
    // }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getAssessments()
    // {
    //     return $this->hasMany(Assessment::className(), ['user_id' => 'id']);
    // }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getAssessments0()
    // {
    //     return $this->hasMany(Assessment::className(), ['user_id' => 'id']);
    // }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getChatMessages()
    // {
    //     return $this->hasMany(ChatMessage::className(), ['user_id' => 'id']);
    // }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getChatUsers()
    // {
    //     return $this->hasMany(ChatUsers::className(), ['user_id' => 'id']);
    // }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getComplaints()
    // {
    //     return $this->hasMany(Complaints::className(), ['user_from' => 'id']);
    // }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getComplaints0()
    // {
    //     return $this->hasMany(Complaints::className(), ['user_id' => 'id']);
    // }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getFavorites()
    // {
    //     return $this->hasMany(Favorites::className(), ['user_id' => 'id']);
    // }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getHistoryOperations()
    // {
    //     return $this->hasMany(HistoryOperations::className(), ['user_id' => 'id']);
    // }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getOrders()
    // {
    //     return $this->hasMany(Orders::className(), ['user_id' => 'id']);
    // }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getUsersCatalogs()
    // {
    //     return $this->hasMany(UsersCatalog::className(), ['user_id' => 'id']);
    // }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getUsersPromotions()
    // {
    //     return $this->hasMany(UsersPromotion::className(), ['user_id' => 'id']);
    // }

    // /**
    //  * Gets query for [[UsersBalls]].
    //  *
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getUsersBalls()
    // {
    //     return $this->hasMany(UsersBall::className(), ['user_from' => 'id']);
    // }

    // /**
    //  * Gets query for [[UsersBalls0]].
    //  *
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getUsersBalls0()
    // {
    //     return $this->hasMany(UsersBall::className(), ['user_to' => 'id']);
    // }

    // /**
    //  * Gets query for [[UsersReytings]].
    //  *
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getUsersReytings()
    // {
    //     return $this->hasMany(UsersReyting::className(), ['user_id' => 'id']);
    // }

    /*shartli ravishda saqlanish joyi fiksrlangan, keyinchalik o;zgarishi mumkin*/
    public function upload()
    {
        if(!empty($this->image))
        {   
            if(file_exists('uploads/avatars/'.$this->avatar) && $this->avatar != null)
            {
                unlink('uploads/avatars/'.$this->avatar);
            }

            $fileName = time() . '_' . $this->image->baseName . '.' . $this->image->extension;
            $this->image->saveAs('uploads/avatars/' . $fileName);
            Yii::$app->db->createCommand()->update('users', ['avatar' => $fileName], [ 'id' => $this->id ])->execute();
        }
    }

    /*shartli ravishda saqlanish joyi fiksrlangan, keyinchalik o;zgarishi mumkin*/
    public function uploadPassport()
    {
        if(!empty($this->passport_image))
        {   
            if(file_exists('uploads/avatars/'.$this->passport_file) && $this->passport_file != null)
            {
                unlink('uploads/avatars/'.$this->passport_file);
            }

            $fileName = time() . '_' . $this->passport_image->baseName . '.' . $this->passport_image->extension;
            $this->passport_image->saveAs('uploads/avatars/' . $fileName);
            Yii::$app->db->createCommand()->update('users', ['passport_file' => $fileName], [ 'id' => $this->id ])->execute();
        }
    }

    /*shartli ravishda saqlanish joyi fiksrlangan, keyinchalik o;zgarishi mumkin*/
    public function uploadCompanyFiles()
    {
        if(!empty($this->company_image))
        {   
            if(file_exists('uploads/avatars/'.$this->company_files) && $this->company_files != null)
            {
                unlink('uploads/avatars/'.$this->company_files);
            }

            $fileName = time() . '_' . $this->company_image->baseName . '.' . $this->company_image->extension;
            $this->company_image->saveAs('uploads/avatars/' . $fileName);
            Yii::$app->db->createCommand()->update('users', ['company_files' => $fileName], [ 'id' => $this->id ])->execute();
        }
    }

    public function downloadPassport()
    {
        if($this->passport_file == '' || $this->passport_file == null) {
            return null; 
        } else {
            return Html::a($this->passport_file . ' <i class="fa fa-download"></i>', ['/users/send-file', 'file' => $this->passport_file],[ 'title'=> 'Скачать', 'data-pjax' => 0]); 
        }
    }

    public function downloadCompanyFiles()
    {
        if($this->company_files == '' || $this->company_files == null) {
            return null; 
        } else {
            return Html::a($this->company_files . ' <i class="fa fa-download"></i>', ['/users/send-file', 'file' => $this->company_files],[ 'title'=> 'Скачать', 'data-pjax' => 0]); 
        }
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

    // public function getPromotions()
    // {
    //     return UsersPromotion::find()->where(['user_id' => $this->id])->all();
    // }

    // public function getHistories()
    // {
    //     return HistoryOperations::find()->where(['user_id' => $this->id])->all();
    // }

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
        return '000';
    }

    public function getAvatarForSite()
    {
        $siteName = Yii::$app->params['siteName'];

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/avatars/' . $this->avatar)) {
            $path = $siteName . '/backend/web/img/no-logo.png';
        } else {
            $path = $siteName . '/backend/web/uploads/avatars/' . $this->avatar;
        }
        return $path;
    }

    // registratsiyadan o'tgan userdan qaytadigan ma'lumot
    public function getUsersMinValues()
    {
         $result = [
            'userId' => $this->id,
            'userType' => $this->type,
            'userTypeName' => $this->getTypeDescription(),
            'userFIO' => $this->fio,
            'userPhone' => $this->phone!=="" ? $this->phone : null,
            'access_token' => $this->access_token,
            'expiret_at' => $this->expiret_at,
            'login' => $this->login,
            // 'firebase_token' => $this->firebase_token,
        ];
        return $result;
    }
}