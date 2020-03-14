<?php

namespace api\modules\v1\models;

use Yii;
use yii\web\UploadedFile;

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
    public $imageFiles;
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
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg',],
            [['text', 'image'], 'string'],
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
            'image' => 'Картинка',
            'imageFiles' => 'Фотографии',
        ];
    }

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

    public function getImage()
    {
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/promotions/' . $this->image ) || $this->image == null) {
            $path = 'http://' . $_SERVER['SERVER_NAME'].'/admin/img/no-logo.png';
        } else {
            $path = 'http://' . $_SERVER['SERVER_NAME'].'/admin/uploads/promotions/'.$this->image;
        }
        return $path;
    }

    public static function getPromotions()
    {
        $promotions = Promotions::find()->all();
        $array = [];
        foreach ($promotions as $key => $value) {
            $array [] = [
                'id' => $value->id,
                'name' => $value->name,
                'price' => (int)$value->price ." ". Yii::t('app',"So'm"),
                'premium' => (int) $value->premium,
                'top' => (int) $value->top,
                'image' => $value->getImage(),
            ];
        }
        return $array;
    }


}
