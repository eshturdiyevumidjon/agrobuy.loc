<?php

namespace backend\models;

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

    public function upload()
    {
        $this->imageFiles = UploadedFile::getInstance($this,'imageFiles');
        if(!empty($this->imageFiles))
        {
            $name = $this->id . '-' . time();
            $this->imageFiles->saveAs('uploads/promotions/' . $name.'.'.$this->imageFiles->extension);
            Yii::$app->db->createCommand()->update('promotions', ['image' => $name.'.'.$this->imageFiles->extension], [ 'id' => $this->id ])->execute();
        }
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

    public function getImage($for = '_form')
    {
        $adminka = Yii::$app->params['adminka'];
        if($for =='_form') {
            return $this->image ? '<img style="width:100%; height:200px; border-radius:10%;" src="/'.$adminka.'/uploads/promotions/' . $this->image .'">' : '<img style="width:100%; height:200px; border-radius:10%;" src="/'.$adminka.'/uploads/noimg.jpg">';
        }
        if($for == '_columns') {
           return $this->image  ? '<img style="width:90px; border-radius:10%;" src="/'.$adminka.'/uploads/promotions/' . $this->image .' ">' : '<img style="width:60px;" src="/'.$adminka.'/uploads/noimg.jpg">';
        }
        if($for == 'main_page') {
            $siteName = Yii::$app->params['siteName'];
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/promotions/' . $this->image)) {
                return $siteName . '/backend/web/img/no-logo.png';
            } else {
                return $siteName . '/backend/web/uploads/promotions/' . $this->image;
            }
        }
    }
}
