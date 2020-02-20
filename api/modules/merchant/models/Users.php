<?php

namespace api\modules\merchant\models;

use Yii;
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
            [['type', 'expiret_at', 'legal_status', 'check_phone', 'check_mail', 'check_passport', 'check_car', 'access'], 'integer'],
            [['balance'], 'number'],
            [['birthday'], 'safe'],
            [['email'], 'email'],
            [['login', 'phone'], 'unique'],
            [['login', 'type', 'phone'], 'required'],
            [['inn'], 'string', 'min' => 9],
            ['password', 'required', 'when' => function($model) {return $this->isNewRecord;}, 'enableClientValidation' => false],
            [['image','new_password', 'passport_image', 'company_image'], 'safe'],
            [['company_files', 'passport_issue', 'access_comment'], 'string'],
            [['login', 'password', 'fio', 'avatar', 'phone', 'email', 'access_token', 'user_number', 'instagram', 'facebook', 'telegram', 'company_name', 'passport_serial_number', 'passport_number', 'passport_date', 'passport_file', 'code_for_phone', 'web_site'], 'string', 'max' => 255],
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
            'fio' => 'Ф.И.О',
            'password' => 'Пароль',
            'avatar' => 'Аватар',
            'phone' => 'Телефон',
            'type' => 'Должность',
            'email' => Yii::t('app', 'E-mail'),
            'balance' =>'Баланс',
            'access' => 'Доступ',
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
            'new_password' => 'Новый пароль',
            'access_comment' => "Текст заблокировки",
            'is_checked' => 'Проверено или нет',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {

        }
        
        return parent::beforeSave($insert);
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

    public function getAccessType()
    {
        return [
            1 => "Активирован",
            2 => "Заблокирован",
        ];
    }

    public static function getLegal()
    {
        return [
            1 => "Физ. лицо",
            2 => "ИП или Юр. лицо",
        ];
    }
}
