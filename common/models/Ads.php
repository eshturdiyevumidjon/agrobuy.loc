<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use backend\models\Currency;
use backend\models\Reyting;
use backend\models\UsersReyting;

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
    public $comment;
    const SCENARIO_DELETING = 'removing';

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
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg',],
            [['user_id', 'type', 'category_id', 'subcategory_id', 'treaty', 'currency_id', 'region_id', 'district_id', 'status'], 'integer'],
            [['images', 'city_name', 'text'], 'string'],
            [['price', 'old_price'], 'number'],
            [['date_cr','comment'], 'safe'],
            [['type', 'title', 'currency_id', 'category_id', 'subcategory_id'], 'required'],
            [['title', 'unit_price'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['subcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subcategory::className(), 'targetAttribute' => ['subcategory_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => Districts::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::className(), 'targetAttribute' => ['region_id' => 'id']],
            [['comment'],'required', 'on' => self::SCENARIO_DELETING],
            
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DELETING] = ['comment'];
        return $scenarios;
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
            'comment' => 'Причина',
            'currency_id' => 'Валюта',
            'region_id' => 'Город,Регион',
            'district_id' => 'Район',
            'status' => 'Статус',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->status = 1;
            $this->date_cr = date('Y-m-d H:i:s');
        }
        
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert) { // bu qism reytingni hisoblash uchun kerak
            $identity = Yii::$app->user->identity;
            $reyting = Reyting::find()->where(['key' => 'create_ads'])->one();
            
            $userReyting = new UsersReyting();
            $userReyting->user_id = $identity->id;
            $userReyting->reyting_id = $reyting->id;
            $userReyting->ball = $reyting->ball;
            $userReyting->save();
        } 
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Gets query for [[Currency]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[District]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(Districts::className(), ['id' => 'district_id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Regions::className(), ['id' => 'region_id']);
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

    public function getStatusList()
    {
        return [
            1 => "Активно",
            2 => "Не активно",
        ];
    }

    public function getRegionsList()
    {
        $region = Regions::find()->all();
        return ArrayHelper::map($region, 'id', 'name');
    }

    public function getCategoryList()
    {
        $categories = Category::find()->all();
        return ArrayHelper::map($categories, 'id', 'title');
    }

    public function getUsersList()
    {
        $users = Users::find()->all();
        return ArrayHelper::map($users, 'id', 'fio');
    }

    public function getCurrencyList()
    {
        $cur = Currency::find()->all();
        return ArrayHelper::map($cur, 'id', 'name');
    }

    public function getCategoryListForSite()
    {
        $categories = Category::find()->all();
        $result = [ '' => Yii::t('app', "Tanlang") ];
        foreach ($categories as $value) {
            $result += [
                $value->id => $value->title,
            ];
        }
        return $result;
    }

    public function getSubcategoryListForSite($category_id)
    {
        $subcategories = Subcategory::find()->where(['category_id' => $category_id])->all();
        $result = [ '' => Yii::t('app', "Tanlang") ];
        foreach ($subcategories as $value) {
            $result += [
                $value->id => $value->name,
            ];
        }
        return $result;
    }

    /*public function getRegionsListForSite()
    {
        $region = Regions::find()->all();
        $result = [ '' => 'Выберите' ];
        foreach ($region as $value) {
            $result += [
                $value->id => $value->name,
            ];
        }
        return $result;
    }*/


    public function getSubcategoryList()
    {
        $subcategories = Subcategory::find()->all();
        return ArrayHelper::map($subcategories, 'id', 'name');
    }

    public function getTreaty()
    {
        return [
            1 => "Да",
            0 => "Нет",
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
            return $this->images ? '<img style="width:100%; height:200px; border-radius:10%;" src="/'.$adminka.'/uploads/ads/' . $this->images .'">' : '<img style="width:100%; height:200px; border-radius:10%;" src="/'.$adminka.'/uploads/noimg.jpg">';
        }
        if($for == '_columns') {
           return $this->images  ? '<img style="width:90px; border-radius:10%;" src="/'.$adminka.'/uploads/ads/' . $this->images .' ">' : '<img style="width:60px;" src="/'.$adminka.'/uploads/noimg.jpg">';
        }
        if($for == 'main_page') {
            $siteName = Yii::$app->params['siteName'];
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/ads/' . $this->images) || $this->images == null) {
                return $siteName . '/backend/web/img/no-images.jpg';
            } else {
                return $siteName . '/backend/web/uploads/ads/' . $this->images;
            }
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

    public function getStar($favorites)
    {
        foreach ($favorites as $value) {
            if($value->field_id == $this->id) return true;
        }
        return false;
    }

    public function getAddress()
    {
        if($this->region_id != null) {
            if($this->district_id != null) {
                return $this->region->name . ' ' . $this->district->name;
            }
            return $this->region->name;
        }
        else return '';
    }
}
