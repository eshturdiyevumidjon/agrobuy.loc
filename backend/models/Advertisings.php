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
            [['time'], 'number', 'min' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => 'Наименование',
            'key' => 'Ключ',
            'time' => 'Время (секунд)',
        ];
    }

    public function beforeDelete()
    {
        $items = AdvertisingItems::find()->where(['advertising_id' => $this->id])->all();
        foreach ($items as $item){
            $item->unlinkFile($item->file);
            $item->delete();
        }
        return parent::beforeDelete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisingItems()
    {
        return $this->hasMany(AdvertisingItems::className(), ['advertising_id' => 'id']);
    }
}
