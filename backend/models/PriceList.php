<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "price_list".
 *
 * @property int $id
 * @property float|null $price Сумма
 * @property int|null $number Порядковый номер
 */
class PriceList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'price_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['number'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'price' => Yii::t('app', 'Price'),
            'number' => Yii::t('app', 'Number'),
        ];
    }
}
