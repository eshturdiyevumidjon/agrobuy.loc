<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "promotions".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $text Текст
 * @property float|null $price Сумма
 * @property int|null $days Количество дней
 * @property int|null $premium Премиум
 * @property int|null $top Топ
 * @property int|null $discount Скидка %
 *
 * @property UsersPromotion[] $usersPromotions
 */
class Promotions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promotions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['price'], 'number'],
            [['price', 'name', 'days', 'text'], 'required'],
            [['days', 'premium', 'top', 'discount'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => 'Наименование',
            'text' => 'Текст',
            'price' => 'Сумма',
            'days' =>'Количество дней',
            'premium' => 'Премиум',
            'top' =>'Топ',
            'discount' => 'Скидка %',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersPromotions()
    {
        return $this->hasMany(UsersPromotion::className(), ['promotion_id' => 'id']);
    }

    public function getTopDescription()
    {
        if($this->top == 1) return "Да";
        else return "Нет";
    }

    public function getPremiumDescription()
    {
        if($this->premium == 1) return "Да";
        else return "Нет";
    }
}
