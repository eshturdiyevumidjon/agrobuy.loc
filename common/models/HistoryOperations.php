<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "history_operations".
 *
 * @property int $id
 * @property int|null $user_id Пользователь
 * @property int|null $type Тип
 * @property string|null $date_cr Дата создание
 * @property string|null $field_id № объявление
 * @property float|null $summa Сумма
 *
 * @property Users $user
 */
class HistoryOperations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history_operations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type'], 'integer'],
            [['date_cr'], 'safe'],
            [['summa'], 'number'],
            [['field_id'], 'string', 'max' => 255],
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
            'user_id' => Yii::t('app', 'User ID'),
            'type' => Yii::t('app', 'Type'),
            'date_cr' => Yii::t('app', 'Date Cr'),
            'field_id' => Yii::t('app', 'Field ID'),
            'summa' => Yii::t('app', 'Summa'),
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
