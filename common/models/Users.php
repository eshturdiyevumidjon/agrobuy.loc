<?php

namespace common\models;

use backend\base\AppActiveQuery;
use Yii;

use yii\behaviors\BlameableBehavior;
use yii\web\ForbiddenHttpException;
use backend\models\Companies;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $login Логин
 * @property string|null $password Пароль
 * @property string|null $fio ФИО
 * @property string|null $avatar Фото
 * @property string|null $phone Телефон
 * @property int|null $type Тип
 * @property string|null $email Эмаил
 * @property float|null $balans Баланс
 * @property string|null $org_name Наименование
 * @property string|null $access_token Токен
 * @property int|null $expiret_at
 * @property int|null $axpierat_at
 *
 * @property ChatMessage[] $chatMessages
 * @property ChatUsers[] $chatUsers
 * @property GroupsOffer[] $groupsOffers
 * @property GroupsUser[] $groupsUsers
 * @property Reyting[] $reytings
 * @property Companies $company
 */
class Users extends \yii\db\ActiveRecord
{
     public $new_password;
     public $image;
     const EXPIRE_TIME = 3600*24*7;

    /**
     * {@inheritdoc}
     */
    
    public static function tableName()
    {
        return 'users';
    }

    public static function find()
    {

        if(isset(Yii::$app->user->identity->id))
        {   

            if(Yii::$app->user->identity->type === 4)
            {   
                $companyId = Yii::$app->user->identity->company_id;
            }
            else $companyId = null;
        } 
        else $companyId = null;
        return new AppActiveQuery(get_called_class(), [
           'companyId' => $companyId,
        ]);
    }

     public function rules()
    {
        return [
            [['avatar'], 'string'],
            [['type', 'expiret_at'], 'integer'],
            [['balans'], 'number'],
            [['fio','login','phone',], 'required'],
            ['password', 'required', 'when' => function($model) {return $this->isNewRecord;}, 'enableClientValidation' => false],
            [['image','new_password'], 'safe'],
            [['login', 'password', 'fio', 'phone', 'email', 'access_token'], 'string', 'max' => 255],
             
        ];
    }

   
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'fio' => 'ФИО',
            'avatar' => 'Фото',
            'image' => 'Фото',
            'phone' => 'Телефон',
            'type' => 'Тип',
            'email' => 'Email',
            'new_password'=>'Новый пароль',
            'balans' => 'Баланс',
            'company_id' => 'Компания',
            'chek_advertising' => 'Виберыте реклами',
            'date_cr' => 'Дата создания',
            'access_token' => 'Токен',
            'expiret_at' => 'Expiret At',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord)
        {
            $user = Yii::$app->user->identity;
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            $this->access_token = Yii::$app->getSecurity()->generateRandomString();
            $this->expiret_at = time() + $this::EXPIRE_TIME;

            
        }

        if($this->new_password != null) $this->password = Yii::$app->security->generatePasswordHash($this->new_password);
        return parent::beforeSave($insert);
    }

    public function upload()
    {
        if(!empty($this->image))
        {   
            if(file_exists('uploads/avatars/'.$this->avatar) && $this->avatar != null)
          {
              unlink('uploads/avatars/'.$this->avatar);
          }

            $this->image->saveAs('uploads/avatars/'.$this->image->baseName.'.'.$this->image->extension);
            Yii::$app->db->createCommand()->update('users', ['avatar' => $this->image->baseName.'.'.$this->image->extension], [ 'id' => $this->id ])->execute();
        }
    }

    /**
     * @return bool
     */

    public function beforeDelete()
    {
        return parent::beforeDelete();
    }

    public static function getType()
    {
        return [
            1 => "Администратор",
            2 => "Модератор",
            // 3 => "Ползователь",
            // 4 => "Образование",
        ];
    }


    public static function getTypeEdu()
    {
        return [
            1 => "Администратор",
            2 => "Модератор",
            3 => "Ползователь",
            4 => "Образование",
        ];
    }

    public function getTypeDescription()
    {
        switch ($this->type) {
            case 1: return "Администратор";
            case 2: return "Модератор";
            case 3: return "Пользователь";
            case 4: return "Образование";
            default: return "Неизвестно";
        }
    }

     public static function getPerDescription($type = null)
    {
        switch ($type) {
            case 1: return "Администратор";
            case 2: return "Модератор";
            case 3: return "Пользователь";
            case 4: return "Образование";
            default: return "Неизвестно";
        }
    }
}
