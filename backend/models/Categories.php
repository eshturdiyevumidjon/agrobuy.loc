<?php

namespace backend\models;

use Yii;
use backend\models\SubCategories;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string|null $name Наименование
 *
 * @property Groups[] $groups
 */
class Categories extends \yii\db\ActiveRecord
{
    public $translation_title;
    public $trash;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
         return [
            [['title', 'image'], 'string', 'max' => 255],
            [['trash'], 'file'],
            ['title','required'],
            [['translation_title'],'safe'],
        ];
    }
    public static function NeedTranslation()
    {
        return [
            'title'=>'translation_title',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('app','Title'),
            'image' => Yii::t('app','Image'),
            'trash' => Yii::t('app','Image'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Groups::className(), ['category_id' => 'id']);
    }

     public function getSubCategoryList()
    {
        $query = SubCategories::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $query->andFilterWhere(['category_id' => $this->id]);
        return $dataProvider;
    }

    public function getImage($for='_form')
    {
        $adminka = Yii::$app->params['adminka'];
        if($for=='_form')
        return $this->image != null ? '<img style="width:100%;height:100px;border-radius:10%;" src="/'.$adminka.'uploads/category/' . $this->image .'">' : '<img style="width:100%; height:100px;border-radius:10%;" src="/'.$adminka.'uploads/noimg.jpg">';
        if($for=='_columns')
           return $this->image != null ? '<img style="width:60px; height:60px; border-radius:10%;" src="/'.$adminka.'uploads/category/' . $this->image .' ">' : '<img style="width:60px; height:60px;" src="/'.$adminka.'uploads/noimg.jpg">';
    }


    public static function TranslatesTitle($value, $lang)
    {
        $title = Translates::find()
            ->where(['table_name' => $value->tableName(),'field_id' => $value->id,'field_name'=>'title', 'language_code' => $lang])
            ->one()->field_value;

            if($title == null){
                $title = $value->title;
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
                        'title' => $value->title,
                        'image' => $value->image,
                    ];
                }
                else {
                        $title = self::TranslatesTitle($value, Yii::$app->language);
                        $news[] = [
                        'id' => $value->id,
                        'title' => $title,
                        'image' => $value->image,
                    ];
                    
                }
        }
        return $news;
    }

}
