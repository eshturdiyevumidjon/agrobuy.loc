<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sub_categories".
 *
 * @property int $id
 * @property string|null $name Наименование
 *
 * @property Groups[] $groups
 */
class SubCategories extends \yii\db\ActiveRecord
{
    public $translation_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subcategory';
    }

    /**
     * {@inheritdoc}
     */
     public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'],'required'],
            ['translation_name','safe'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public static function NeedTranslation()
    {
        return [
            'name'=>'translation_name',
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'category_id' => 'Категория',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Groups::className(), ['subcategory_id' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }


    public static function TranslateName($value, $lang)
    {
        $title = Translates::find()
            ->where(['table_name' => $value->tableName(),'field_id' => $value->id,'field_name'=>'title', 'language_code' => $lang])
            ->one()->field_value;

            if($title == null){
                $title = $value->name;
            }

        return $title;
    }

    public static function getTranslates($news_all)
    {
        $news  = [];
        foreach ($news_all as  $value) {
                if(Yii::$app->language == 'kr'){
                        $news[] = [
                        'id' => $value->id,
                        'name' => $value->name,
                    ];
                }
                else {
                        $title = self::TranslateName($value, Yii::$app->language);
                        $news[] = [
                        'id' => $value->id,
                        'name' => $title,
                    ];
                    
                }
        }
        return $news;
    }
}
