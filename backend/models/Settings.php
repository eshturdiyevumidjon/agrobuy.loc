<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $name Наименование
 * @property string $key Ключ
 * @property string $value Значание
 */
class Settings extends \yii\db\ActiveRecord
{

    public $translation_value;
    public $translation_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value','name'],'required'],
            [['value'], 'string'],
            [['priority', 'view_in_footerser_id'], 'integer'],
            [['translation_name','translation_value'],'safe'],
            [['name', 'key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' =>'Наименование',
            'key' =>'Ключ',
            'value' =>'Значание',
            'priority' =>'Приоритет',
            'view_in_footerser_id' =>'Показать в футере',
            'translation_name' =>Yii::t('app','Translation name'),
            'translation_value' =>Yii::t('app','Translation value'),
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->key = strtolower(str_replace(' ', '', $this->name)).time();
        }
        
        return parent::beforeSave($insert);
    }

    public static function NeedTranslation()
    {
        return [
            'name'=>'translation_name',
            'value'=>'translation_value',
        ];
    }
    public static function TranslatesName($value, $lang)
    {
        $text = Translates::find()
            ->where(['table_name' => $value->tableName(),'field_id' => $value->id,'field_name'=>'name', 'language_code' => $lang])
            ->one()->field_value;

            if($text == null){
                $text = $value->name;
            }

        return $text;
    }

    public static function TranslatesValue($value, $lang)
    {
        $title = Translates::find()
            ->where(['table_name' => $value->tableName(),'field_id' => $value->id,'field_name'=>'value', 'language_code' => $lang])
            ->one()->field_value;

            if($title == null){
                $title = $value->value;
            }

        return $title;
    }

 public static function getView()
    {
        return [
            1 => "Да",
            0 => "Нет",
        ];
    }

    public static function getTranslates($news_all)
    {
        $news  = [];
        foreach ($news_all as  $value) {
            if(Yii::$app->language == 'ru')
                {
                    $news[] = [
                    'id' => $value->id,
                    'name' => $value->name,
                    'value' => $value->value,
                ];
            }
            else {
                    $title = Settings::TranslatesName($value, Yii::$app->language);
                    $text = Settings::TranslatesValue($value, Yii::$app->language);
                    $news[] = [
                    'id' => $value->id,
                    'name' => $title,
                    'value' => $text,
                ];
                
            }
        }
        return $news;
    }

    public function getType()
    {
        return [
            1 => 'Да',
            0 => 'Нет',
        ];
    }

}

