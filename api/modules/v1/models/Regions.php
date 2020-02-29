<?php
namespace api\modules\v1\models;


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
            [['name'], 'string', 'max' => 255],
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

    /**
     * Gets query for [[Ads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasMany(Ads::className(), ['district_id' => 'id']);
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
    public function getDistrictsList($region, $districts)
    {
        $result = [];
        foreach ($districts as $value) {
            if($region->id == $value->region_id){
                $result [] = [
                    'id' => $value->id,
                    'name' => $value->name,
                ];
            }
        }
        return $result;
    }
}
