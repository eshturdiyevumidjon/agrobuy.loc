<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "advertisings".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $key Ключ
 *
 * @property AdvertisingItems[] $advertisingItems
 */
class Advertisings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertisings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'key' => Yii::t('app', 'Key'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisingItems()
    {
        return $this->hasMany(AdvertisingItems::className(), ['advertising_id' => 'id']);
    }
}
