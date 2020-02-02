<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "users_ball".
 *
 * @property int $id
 * @property int|null $user_from От пользователя
 * @property int|null $user_to Пользователь
 * @property float|null $ball Балл
 * @property string|null $date_cr Дата создание
 *
 * @property Users $userFrom
 * @property Users $userTo
 */
class UsersBall extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_ball';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_from', 'user_to'], 'integer'],
            [['ball'], 'number'],
            [['date_cr'], 'safe'],
            [['user_from'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_from' => 'id']],
            [['user_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_to' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_from' => 'От пользователя',
            'user_to' => 'Пользователь',
            'ball' => 'Балл',
            'date_cr' => 'Дата создание',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->date_cr = date('Y-m-d H:i:s');
        }

        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[UserFrom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserFrom()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_from']);
    }

    /**
     * Gets query for [[UserTo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserTo()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_to']);
    }

    //eng yuqori ballga ega bolgan dastlabki 5 ta userning idsini yigib olish funksiyasi
    public function getUsersList()
    {
        $usersBall = UsersBall::find()->all();

        $userID = [];
        foreach ($usersBall as $value) {
            $userID += [ $value->user_to => 0 ];
        }

        foreach ($usersBall as $value) {
            $userID[$value->user_to] = $userID[$value->user_to] + $value->ball;
        }

        foreach ($userID as $key => $value) {
            $count = 0;
            foreach ($usersBall as $ball) {
                if($key == $ball->user_to) $count++;
            }
            $userID[$key] = round($userID[$key] / $count, 1);
        }

        arsort($userID);
        $result = []; $i = 1;
        foreach ($userID as $key => $value) {
            $result [] = $key;
            if($i >= 5) break;
            $i++;
        }

        return $result;
    }
}
