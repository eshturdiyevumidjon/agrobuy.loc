<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "ads".
 *
 * @property int $id
 * @property int|null $user_id Пользователь
 * @property int|null $type Тип
 * @property string|null $title Заголовок
 * @property string|null $images Фотографии
 * @property int|null $category_id Категория
 * @property int|null $subcategory_id Субкатегория
 * @property string|null $city_name Город,регион
 * @property string|null $text Текст объявлении
 * @property float|null $price Цена
 * @property float|null $old_price Старая цена
 * @property string|null $unit_price Цена за единицу
 * @property int|null $treaty Договорная
 * @property string|null $date_cr Дата создание
 *
 * @property Category $category
 * @property Subcategory $subcategory
 * @property Users $user
 * @property Complaints[] $complaints
 * @property UsersCatalog[] $usersCatalogs
 */
class Ads extends \yii\db\ActiveRecord
{
    public $imageFiles;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'category_id', 'subcategory_id', 'treaty'], 'integer'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 10],
            [['price', 'old_price'], 'number'],
            [['date_cr'], 'safe'],
            [['title', 'unit_price'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['subcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subcategory::className(), 'targetAttribute' => ['subcategory_id' => 'id']],
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
            'type' => 'Тип',
            'title' =>'Заголовок',
            'images' =>'Фотографии',
            'category_id' => 'Категория',
            'subcategory_id' => 'Субкатегория',
            'city_name' =>'Город,Регион',
            'text' =>'Текст объявлении',
            'price' =>'Цена',
            'old_price' => 'Старая цена',
            'unit_price' => 'Цена за единицу',
            'treaty' => 'Договорная',
            'date_cr' => 'Дата создание',
            'imageFiles' => 'Фотографии',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory()
    {
        return $this->hasOne(Subcategory::className(), ['id' => 'subcategory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplaints()
    {
        return $this->hasMany(Complaints::className(), ['ads_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersCatalogs()
    {
        return $this->hasMany(UsersCatalog::className(), ['ads_id' => 'id']);
    }

    public function getType()
    {
        return [
            1 => "Куплю",
            2 => "Продам",
        ];
    }

    public function getCategoryList()
    {
        $categories = Category::find()->all();
        return ArrayHelper::map($categories, 'id', 'title');
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) 
        {
            $this->date_cr = date('Y-m-d');
        }
        return parent::beforeSave($insert);
    }

    public function getSubcategoryList()
    {
        $subcategories = Subcategory::find()->all();
        return ArrayHelper::map($subcategories, 'id', 'name');
    }

    public function getTreaty()
    {
        return [
            1 => "Да",
            2 => "Нет",
        ];
    }

    public function getDate($date)
    {
        if($date != null) return date('d.m.Y', strtotime($date) );
        else $date;
    }

    public function getImage($for = '_form')
    {
        $adminka = Yii::$app->params['adminka'];
        if($for =='_form') {
            return $this->images ? '<img style="width:100%;border-radius:10%;" src="/'.$adminka.'/uploads/ads/' . $this->images .'">' : '<img style="width:100%; max-height:300px;border-radius:10%;" src="/'.$adminka.'/uploads/noimg.jpg">';
        }
        if($for == '_columns') {
           return $this->images  ? '<img style="width:90px; border-radius:10%;" src="/'.$adminka.'/uploads/ads/' . $this->images .' ">' : '<img style="width:60px;" src="/'.$adminka.'/uploads/noimg.jpg">';
        }
    }

    public function upload()
    {
        $this->imageFiles = UploadedFile::getInstance($this,'imageFiles');
        if(!empty($this->imageFiles))
        {
            $name = $this->id . '-' . time();
            $this->imageFiles->saveAs('uploads/ads/' . $name.'.'.$this->imageFiles->extension);
            Yii::$app->db->createCommand()->update('ads', ['images' => $name.'.'.$this->imageFiles->extension], [ 'id' => $this->id ])->execute();
        }
    }

    public function unlinkFile($file)
    {
        if( file_exists('uploads/ads/' . $file) ) unlink('uploads/ads/' . $file);
    }
}
