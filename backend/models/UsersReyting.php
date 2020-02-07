<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "users_reyting".
 *
 * @property int $id
 * @property int|null $user_id Пользователь
 * @property int|null $reyting_id Рейтинг
 * @property string|null $date_cr Дата создание
 * @property float|null $ball Балл
 *
 * @property Reyting $reyting
 * @property Users $user
 */
class UsersReyting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_reyting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'reyting_id'], 'integer'],
            [['date_cr'], 'safe'],
            [['ball'], 'number'],
            [['reyting_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reyting::className(), 'targetAttribute' => ['reyting_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'reyting_id' => 'Рейтинг',
            'date_cr' => 'Дата создание',
            'ball' => 'Балл',
        ];
    }

    /**
     * Gets query for [[Reyting]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReyting()
    {
        return $this->hasOne(Reyting::className(), ['id' => 'reyting_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
