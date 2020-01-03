<?php

namespace common\models;

use Yii;
use backend\base\AppActiveQuery;
use yii\behaviors\BlameableBehavior;
use yii\web\ForbiddenHttpException;
use backend\models\Companies;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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
            'password' => Yii::t('app', 'Password'),
            'fio' => 'ФИО',
            'avatar' => 'Аватар',
            'phone' => 'Телефон',
            'type' => 'Должность',
            'email' => Yii::t('app', 'E-mail'),
            'balance' => Yii::t('app', 'Balance'),
            'access_token' => Yii::t('app', 'Access Token'),
            'expiret_at' => Yii::t('app', 'Expiret At'),
            'user_number' => Yii::t('app', 'User Number'),
            'instagram' => Yii::t('app', 'Instagram'),
            'facebook' => Yii::t('app', 'Facebook'),
            'telegram' => Yii::t('app', 'Telegram'),
            'birthday' => Yii::t('app', 'Birthday'),
            'company_name' => Yii::t('app', 'Company Name'),
            'company_files' => Yii::t('app', 'Company Files'),
            'legal_status' => Yii::t('app', 'Legal Status'),
            'inn' => Yii::t('app', 'Inn'),
            'web_site' => Yii::t('app', 'Web Site'),
            'passport_serial_number' => Yii::t('app', 'Passport Serial Number'),
            'passport_number' => Yii::t('app', 'Passport Number'),
            'passport_date' => Yii::t('app', 'Passport Date'),
            'passport_issue' => Yii::t('app', 'Passport Issue'),
            'passport_file' => Yii::t('app', 'Passport File'),
            'check_phone' => Yii::t('app', 'Chesk Phone'),
            'check_mail' => Yii::t('app', 'Chesk Mail'),
            'check_passport' => Yii::t('app', 'Chesk Passport'),
            'check_car' => Yii::t('app', 'Chesk Car'),
            'code_for_phone' => Yii::t('app', 'Code For Phone'),
            'passport_image' => Yii::t('app', 'Passport File'),
            'company_image' => Yii::t('app', 'Company Files'),
        ];
    }


    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            $this->access_token = Yii::$app->getSecurity()->generateRandomString();
            $this->expiret_at = time() + $this::EXPIRE_TIME;
        }

        if($this->new_password != null) $this->password = Yii::$app->security->generatePasswordHash($this->new_password);
        if($this->birthday != null) $this->birthday = date("Y-m-d", strtotime($this->birthday ));
        if($this->passport_date != null) $this->passport_date = date("Y-m-d", strtotime($this->passport_date ));
        
        return parent::beforeSave($insert);
    }

    /**
     * @return bool
     */

    public function beforeDelete()
    {
        return parent::beforeDelete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasMany(Ads::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssessments()
    {
        return $this->hasMany(Assessment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessage::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatUsers()
    {
        return $this->hasMany(ChatUsers::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplaints()
    {
        return $this->hasMany(Complaints::className(), ['user_from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplaints0()
    {
        return $this->hasMany(Complaints::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorites::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoryOperations()
    {
        return $this->hasMany(HistoryOperations::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersCatalogs()
    {
        return $this->hasMany(UsersCatalog::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersPromotions()
    {
        return $this->hasMany(UsersPromotion::className(), ['user_id' => 'id']);
    }

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

    public function getPromotions()
    {
        return UsersPromotion::find()->where(['user_id' => $this->id])->all();
    }

    public function getHistories()
    {
        return HistoryOperations::find()->where(['user_id' => $this->id])->all();
    }
}
