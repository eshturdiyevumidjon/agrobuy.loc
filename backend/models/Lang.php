<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "lang".
 *
 * @property int $id
 * @property string $url Код языка
 * @property string $local Местное название
 * @property string $name Название
 * @property string $image Флаг
 * @property int $default Заметка
 * @property int $create Заметка
 * @property int $status Статус
 * @property int $date_update Дата изменения
 * @property int $date_create Дата создания
 */
class Lang extends \yii\db\ActiveRecord
{
    public $flag;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'name'], 'required'],
            [['default', 'status', 'date_update','create', 'date_create'], 'integer'],
            [['url', 'local', 'name', 'image'], 'string', 'max' => 255],
            [['flag'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg',],
        ];
    }
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Код языка',
            'local' => 'Местное название',
            'name' => 'Название',
            'image' => 'Флаг',
            'default' => 'Заметка',
            'create' => 'Заметка',
            'status' => 'Статус',
            'date_update' => 'Ўзгартирилган вақти',
            'date_create' => 'Яратилган вақти',
            'flag' => 'Флаг',
        ];
    }
    public static function getLanguages()
    {
        return Lang::find()->where(['create'=>1,'status'=>1])->all();
    }

    public static function getLanguagesCompany()
    {
       $user = Yii::$app->user->identity;

        if($user->id != 1 && $user != null){
            $langs = \yii\helpers\ArrayHelper::getColumn(\backend\models\CompanyLanguage::find()->where(['company_id'=>$user->company_id,'status'=>1])->all(),'language_id');
            return Lang::find()->where(['create'=>1,'id'=>$langs,'status'=>1])->all();
        }
        elseif($user != null && $user->id == 1) {
            return Lang::find()->where(['create'=>1,'status'=>1])->all();
        }
    }

    //Получение текущего объекта языка
    static function getCurrent()
    {
       return Lang::find()->where(['url'=>Yii::$app->language])->one();
    }
    public function getStatus()
    {
        return [
                '0' => 'Отключен',
                '1' => 'Активный',
            ];
    }
    public function StatusName()
    {
        return ($this->status=='1')?'Активный':'Отключен';
    }
    public static function getLaguagesList()
    {
        return Lang::find()->where(['create'=>0])->all();
    }

    public function getLangCompany($id)
    {
        $comp_lang = CompanyLanguage::find()->where(['language_id' => $id])->one();
        if($comp_lang->status  == 1) {
            return true;
        }
        else return false;
    }
}
