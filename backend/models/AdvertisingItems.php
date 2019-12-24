<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "advertising_items".
 *
 * @property int $id
 * @property int|null $advertising_id Рекламные баннеры
 * @property string|null $title Заголовок
 * @property string|null $text Текст
 * @property string|null $link Ссылка
 * @property int|null $type Тип рекламы
 * @property string|null $file Файл
 *
 * @property Advertisings $advertising
 */
class AdvertisingItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertising_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['advertising_id', 'type'], 'integer'],
            [['text'], 'string'],
            [['title', 'link', 'file'], 'string', 'max' => 255],
            [['advertising_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertisings::className(), 'targetAttribute' => ['advertising_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'advertising_id' => Yii::t('app', 'Advertising ID'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'link' => Yii::t('app', 'Link'),
            'type' => Yii::t('app', 'Type'),
            'file' => Yii::t('app', 'File'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertising()
    {
        return $this->hasOne(Advertisings::className(), ['id' => 'advertising_id']);
    }
}
