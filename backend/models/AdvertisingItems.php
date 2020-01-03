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
            'advertising_id' => 'Рекламные баннеры',
            'title' =>'Заголовок',
            'text' => 'Текст',
            'link' => 'Ссылка',
            'type' => 'Тип рекламы  ',
            'file' => 'Файл',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertising()
    {
        return $this->hasOne(Advertisings::className(), ['id' => 'advertising_id']);
    }

    public function getImage($for = '_form')
    {
        $adminka = Yii::$app->params['adminka'];
        if($for =='_form') {
            return $this->file ? '<img style="width:100%;border-radius:10%;" src="/'.$adminka.'/uploads/reclama-advert/' . $this->file .'">' : '<img style="width:100%; max-height:300px;border-radius:10%;" src="/'.$adminka.'/uploads/noimg.jpg">';
        }
        if($for == '_columns') {
           return $this->file  ? '<img style="width:90px; border-radius:10%;" src="/'.$adminka.'/uploads/reclama-advert/' . $this->file .' ">' : '<img style="width:60px;" src="/'.$adminka.'/uploads/noimg.jpg">';
        }
    }
}
