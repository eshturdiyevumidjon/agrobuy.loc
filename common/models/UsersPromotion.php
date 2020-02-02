<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users_promotion".
 *
 * @property int $id
 * @property int|null $user_id Пользователь
 * @property int|null $promotion_id Продвижение
 * @property string|null $access_date Срок окончание
 * @property string|null $date_cr Дата создание
 *
 * @property Promotions $promotion
 * @property Users $user
 */
class UsersPromotion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_promotion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'promotion_id'], 'integer'],
            [['access_date', 'date_cr'], 'safe'],
            [['promotion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Promotions::className(), 'targetAttribute' => ['promotion_id' => 'id']],
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
            'promotion_id' => 'Продвижение',
            'access_date' => 'Срок окончание',
            'date_cr' =>'Дата создание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotion()
    {
        return $this->hasOne(\backend\models\Promotions::className(), ['id' => 'promotion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getUsersID()
    {
        $usersPromotion = UsersPromotion::find()->joinWith('promotion')->where(['>=', 'access_date', date('Y-m-d') ])->andWhere(['promotions.premium' => 1])->all();

        $userID = [];
        foreach ($usersPromotion as $value) {
            $userID [] = $value->user_id;
        }
        return $userID;
    }
}
