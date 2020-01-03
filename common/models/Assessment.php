<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "assessment".
 *
 * @property int $id
 * @property int|null $user_id Пользователь
 * @property int|null $ball Балл
 * @property string|null $date_cr Дата создание
 *
 * @property Users $user
 */
class Assessment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assessment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'ball'], 'integer'],
            [['date_cr'], 'safe'],
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
            'user_id' => 'Пользователь',
            'ball' =>'Балл',
            'date_cr' => 'Дата создание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
