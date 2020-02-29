<?php

namespace common\models;
use backend\models\SubCategories;
use frontend\models\Sessions;
use yii\data\ActiveDataProvider;
use backend\models\Translates;

use Yii;

/**
 * This is the model class for table "regions".
 *
 * @property int $id
 * @property string|null $name Наименование
 *
 * @property Districts[] $districts
 */
class Regions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $translation_name;

    public static function tableName()
    {
        return 'regions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['translation_name'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
        ];
    }

    public static function NeedTranslation()
    {
        return [
            'name'=>'translation_name',
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
     * Gets query for [[Ads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasMany(Ads::className(), ['district_id' => 'id']);
    }



    public function getSubcategories()
    {
        return $this->hasMany(Subcategory::className(), ['regions_id' => 'id']);
    }

    public function getSubCategoryList()
    {
        $query = Districts::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $query->andFilterWhere(['region_id' => $this->id]);
        return $dataProvider;
    }

    /**
     * Gets query for [[Districts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistricts()
    {
        return $this->hasMany(Districts::className(), ['region_id' => 'id']);
    }
}

