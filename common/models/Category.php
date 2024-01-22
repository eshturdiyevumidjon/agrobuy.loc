<?php

namespace common\models;

use Yii;
use backend\models\Translates;
use backend\models\SubCategories;
use frontend\models\Sessions;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string|null $title Наименование
 * @property string|null $image Фотография
 *
 * @property Ads[] $ads
 * @property Subcategory[] $subcategories
 */
class Category extends \yii\db\ActiveRecord
{
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Наименование',
            'image' => 'Фотография',
        ];
    }

    public function beforeDelete()
    {
        $subs = SubCategories::find()->where(['category_id' => $this->id])->all();
        foreach ($subs as $sub){
            $sub->delete();
        }
        return parent::beforeDelete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasMany(Ads::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategories()
    {
        return $this->hasMany(Subcategory::className(), ['category_id' => 'id']);
    }

    public function getSubCategoryList($category, $subCategories)
    {
        $session = new Sessions();
        $result = [];

        foreach ($subCategories as $value) {
            if($category->id == $value->category_id){
                if(Yii::$app->language == 'kr') {
                    $result [] = [
                        'id' => $value->id,
                        'name' => $value->name,
                    ];
                }
                else {
                    $name = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'name');
                    $result [] = [
                        'id' => $value->id,
                        'name' => $name,
                    ];
                }
            }
        }

        return $result;
    }

    public static function getAllCategoryList()
    {
        $session = new Sessions();
        $category = Category::find()->all();
        $subCategories = SubCategories::find()->all();
        $result = [];
        $siteName = Yii::$app->params['siteName'];

        foreach ($category as $value) {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/category/' . $value->image) || $value->image == null) {
                $path = $siteName . '/backend/web/img/no-images.png';
            } 
            else {
                $path = $siteName . '/backend/web/uploads/category/' . $value->image;
            }
            if(Yii::$app->language == 'kr') {
                $result [] = [
                    'id' => $value->id,
                    'title' => $value->title,
                    'image' => $path,
                    'subCategory' => $value->getSubCategoryList($value, $subCategories),
                ];
            }
            else {
                $title = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'title');
                $result [] = [
                    'id' => $value->id,
                    'title' => $title,
                    'image' => $path,
                    'subCategory' => $value->getSubCategoryList($value, $subCategories),
                ];
            }
        }

        return $result;
    }
}
