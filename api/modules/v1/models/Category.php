<?php
namespace api\modules\v1\models;

use Yii;
use api\modules\v1\models\Translates;
use api\modules\v1\models\Subcategory;
use api\modules\v1\models\Ads;

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

   
    public function getAds()
    {
        return $this->hasMany(Ads::className(), ['category_id' => 'id']);
    }

  
     
    public function getSubcategories()
    {
        return $this->hasMany(Subcategory::className(), ['category_id' => 'id']);
    }
    //  Ads jadvalidagi categoriyalar soni
    public function getCountCategory()
    {
        return Ads::find()->where(['category_id'=>$this->id])->count();
    }

    //  Ads jadvalidagi SubCatgoriyalar soni
    public function getCountSubCategory($id)
    {
        return Ads::find()->where(['subcategory_id'=>$id])->count();
    }

    public function getNameTranslates($value, $lang,$name)
    {
        $name = Translates::find()
            ->where(['table_name' => $value->tableName(),'field_id' => $value->id,'field_name'=>$name, 'language_code' => $lang])
            ->one()->field_value;

            if($name == null){
                $name = $value->name;
            }

        return $name;
    }

    // translate
    public function getTitleTranslates($value, $lang,$title)
    {
        $title = Translates::find()
            ->where(['table_name' => $value->tableName(),'field_id' => $value->id,'field_name'=>$title, 'language_code' => $lang])
            ->one()->field_value;

            if($title == null){
                $title = $value->title;
            }

        return $title;
    }

    // SubCategorylarni royxati
    public function getSubCategoryList($category, $subCategories)
    {
        $result = [];

        foreach ($subCategories as $value) {
            if($category->id == $value->category_id){
                if(Yii::$app->language == 'kr') {
                    $result [] = [
                        'id' => $value->id,
                        'name' => $value->name,
                        'adsCount' =>(int) $this->getCountSubCategory($value->id), 
                    ];
                }
                else {
                    $name = $this->getNameTranslates($value, Yii::$app->language,'name');
                    $result [] = [
                        'id' => $value->id,
                        'name' => $name,
                        'adsCount' =>(int) $this->getCountSubCategory($value->id), 
                    ];
                }
            }
        }

        return $result;
    }

}
