<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "complaints".
 *
 * @property int $id
 * @property int|null $user_id Пользователь
 * @property int|null $ads_id Объявление
 * @property string|null $text Текст
 * @property string|null $date_cr Дата создание
 * @property int|null $user_from Кто отправил
 *
 * @property Ads $ads
 * @property Users $userFrom
 * @property Users $user
 */
class Complaints extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'complaints';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'ads_id', 'user_from'], 'integer'],
            [['text'], 'string'],
            [['date_cr'], 'safe'],
            [['ads_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ads::className(), 'targetAttribute' => ['ads_id' => 'id']],
            [['user_from'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_from' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' =>'Пользователь',
            'ads_id' => 'Объявление',
            'text' => 'Текст',
            'date_cr' => 'Дата создание',
            'user_from' => 'Кто отправил',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAds()
    {
        return $this->hasOne(Ads::className(), ['id' => 'ads_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFrom()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
