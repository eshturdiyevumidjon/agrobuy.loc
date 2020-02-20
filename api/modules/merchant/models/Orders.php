<?php

namespace api\modules\merchant\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $user_id Пользователь
 * @property string $created_date Дата создание
 * @property double $amount Сумма
 *
 * @property User $user
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'state'], 'integer'],
            [['created_date'], 'safe'],
            [['amount'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'created_date' => 'Дата создание',
            'amount' => 'Сумма',
            'state' => 'Статус заказа',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->user_id = Yii::$app->user->identity->id;
            $this->state = 1;
            $this->created_date = date('Y-m-d H:i:s');
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getStateList()
    {
        return [
            1 => 'Создано',
            2 => 'В ожидании',
            3 => 'Оплачено',
            4 => 'Отменено',
        ];
    }

    public function getAmount()
    {
        return $this->amount/100 . 'so\'m ('. User::getSum($this->amount) . ' у.е.)';
    }

    public function getPriceList()
    {
        return [
            100000 => '1000 сум',
            500000 => '5000 сум',
            1000000 => '10000 сум',
            2000000 => '20000 сум',
            3000000 => '30000 сум',
            4000000 => '40000 сум',
            5000000 => '50000 сум',
            8000000 => '80000 сум',
            10000000 => '100000 сум',
            15000000 => '150000 сум',
            20000000 => '200000 сум',
        ];
    }
}
