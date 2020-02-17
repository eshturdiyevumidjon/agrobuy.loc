<?php

namespace common\models;

use Yii;
use backend\models\Promotions;

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
            'user_id' => 'Пользователь',
            'type' =>'Тип',
            'date_cr' => 'Дата создание',
            'field_id' =>'№ объявление',
            'summa' =>'Сумма',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->date_cr = date("Y-m-d H:i:s");
        }
        
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public static function getType()
    {
        return [
            1 => "Пополнение счета",
            2 => "Платная услуга",
        ];
    }

    public function getTypeDescription()
    {
        switch ($this->type) {
            case 1: return "Пополнение счета";
            case 2: return "Платная услуга";
            default: return "Неизвестно";
        }
    }    

    public function getDescription()
    {
        if($this->type == 1){
            return 'Пополнено баланс';
        }
        else{
            if($this->type == 2){
                $promotion = Promotions::findOne($this->field_id);
                if($promotion != null) return "Куплено платная услуга <b>({$promotion->name})</b>";
                else return "Неизвестно";
            }
            else{
                return "Неизвестно";
            }
        }
    }

    public function getPromotion()
    {
        $promotion = Promotions::findOne($this->field_id);
        if($promotion != null) return $promotion;
    }
}
