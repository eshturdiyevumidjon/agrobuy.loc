<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use backend\models\Currency;
use backend\models\Reyting;
use backend\models\UsersReyting;
use frontend\models\Sessions;
use backend\models\SubCategories;
use backend\models\Promotions;
use backend\models\AboutCompany;

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
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 50],
            [['user_id', 'type', 'category_id', 'subcategory_id', 'treaty', 'currency_id', 'region_id', 'district_id', 'status', 'is_checked', 'top', 'premium'], 'integer'],
            [['images', 'city_name', 'text'], 'string'],
            [['price', 'old_price'], 'number'],
            [['date_cr','comment', 'top_date', 'premium_date'], 'safe'],
            [['type', 'title', 'currency_id', 'category_id', 'subcategory_id','region_id', 'district_id'], 'required'],
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
            'is_checked' => 'Просмотрено',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->status = 1;
            $this->is_checked = 0;
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

    public function getIsCheckedList()
    {
        return [
            1 => "Да",
            0 => "Нет",
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
        $session = new Sessions();
        $region = Regions::find()->all();
        $result = [ '' => Yii::t('app', "Tanlang") ];
        $siteName = 'https://' . $_SERVER['SERVER_NAME'];

        foreach ($region as $value) {
            if(Yii::$app->language == 'kr') {
                $result += [
                    $value->id => $value->name,
                ];
            }
            else {
                $name = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'name');
                $result += [
                    $value->id => $name,
                ];
            }
        }
        return $result;
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

    /*public function getCategoryListForSite()
    {
        $categories = Category::find()->all();
        $result = [ '' => Yii::t('app', "Tanlang") ];
        foreach ($categories as $value) {
            $result += [
                $value->id => $value->title,
            ];
        }
        return $result;
    }*/

    public function getCategoryListForSite()
    {
        $session = new Sessions();
        $category = Category::find()->all();
        $subCategories = SubCategories::find()->all();
        //$result = [];
        $result = [ '' => Yii::t('app', "Tanlang") ];
        $siteName = Yii::$app->params['siteName'];

        foreach ($category as $value) {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/category/' . $value->image) || $value->image == null) {
                $path = $siteName . '/backend/web/img/no-images.png';
            } 
            else {
                $path = $siteName . '/backend/web/uploads/category/' . $value->image;
            }
            if(Yii::$app->language == 'kr') {
                $result += [
                    $value->id => $value->title,
                ];
            }
            else {
                $title = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'title');
                $result += [
                    $value->id => $title,
                ];
            }
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

    public function getDistrictsList($region_id)
    {
        $dist = Districts::find()->where(['region_id' => $region_id])->all();
        $result = [ '' => Yii::t('app', "Tanlang") ];
        foreach ($dist as $value) {
            $result += [
                $value->id => $value->name,
            ];
        }
        return $result;
    }

    public function getDistrictsListForAdmin()
    {
        $dist = Districts::find()->all();
        return ArrayHelper::map($dist, 'id', 'name');
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
        $explode = explode(',', $this->images);
        $img = null;
        foreach ($explode as $file) {
            $img = '/backend/web/uploads/ads/' . $file;
            if(file_exists($img) && $file != null) {$img = $file; break;}
        }

        $adminka = Yii::$app->params['adminka'];
        if($for =='_form') {
            return $img ? '<img style="width:100%; height:200px; border-radius:10%;" src="/'.$adminka.'/uploads/ads/' . $img .'">' : '<img style="width:100%; height:200px; border-radius:10%;" src="/'.$adminka.'/uploads/noimg.jpg">';
        }
        if($for == '_columns') {
           return $img  ? '<img style="width:90px; border-radius:10%;" src="/'.$adminka.'/uploads/ads/' . $img .' ">' : '<img style="width:60px;" src="/'.$adminka.'/uploads/noimg.jpg">';
        }
        if($for == 'main_page') {
            $siteName = Yii::$app->params['siteName'];
            if (!file_exists('/backend/web/uploads/ads/' . $img) || $img == null) {
                return $siteName . '/backend/web/img/no-images.jpg';
            } else {
                return $siteName . '/backend/web/uploads/ads/' . $img;
            }
        }
    }

    public function getImages()
    {
        $siteName = Yii::$app->params['siteName'];
        $explode = explode(',', $this->images);
        $result = '';
        foreach ($explode as $file) {
            $img = $_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/ads/' . $file;
            if(file_exists($img) && $file != null)
            {
                $img = $siteName . '/backend/web/uploads/ads/' . $file;
                $result .= '<div class="image_preview_class" id="'.$file . '_' . $this->id.'"><a class="img-ads" data-id="' . $this->id . '" data-path="' . $file . '" >x</a><span class="preview"><img src="' . $img . '"></span></div>';
            }
        }
        return $result;
    }

    public function getImagesPath()
    {
        $siteName = Yii::$app->params['siteName'];
        $explode = explode(',', $this->images);
        $result = [];
        foreach ($explode as $file) {
            $img = $_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/ads/' . $file;
            if(file_exists($img) && $file != null)
            {
                $img = $siteName . '/backend/web/uploads/ads/' . $file;
                $result [] = $img;
            }
        }
        return $result;
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

    public function uploads()
    {
        if(!empty($this->imageFiles)) {
            $string = '';
            $explode = explode(',', $this->images);
            foreach ($explode as $file) {
                if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/ads/' . $file) && $file != null) {
                    if($string == '') $string = $file;
                    else $string .= ',' . $file;
                }
            }
            
            foreach ($this->imageFiles as $file) {
                $fileName = $this->id . '-' . Yii::$app->security->generateRandomString() . '.' . $file->extension;
                $file->saveAs('@backend/web/uploads/ads/' . $fileName);
                if($string == '') $string = $fileName;
                else $string .= ',' . $fileName;
            }

            $this->images = $string;
            $this->save(false);
            return true;
        } else {
            return false;
        }
    }

    public function UploadImage($post)
    {
        $uploaded_files = $post['uploaded_files'];
        $old_uploaded_files = $post['old_uploaded_files'];
        $source_path = Yii::getAlias('@backend/web/uploads/ads_trash/');
        $destination_path = Yii::getAlias('@backend/web/uploads/ads/');

        if($uploaded_files != "")
        {
            $images = explode(",",$uploaded_files);
            $names= [];
            foreach ($images as $value) {
                if(file_exists($source_path.$value)){
                    $ext = substr(strrchr($value, "."), 1); 
                    $fileName = $this->id . '-' . Yii::$app->security->generateRandomString() . '.' . $ext;
                    $names[] = $fileName;
                    copy($source_path.$value, $destination_path . $fileName);
                    unlink($source_path.$value);
                }
            }  
            $new_images = implode(",", $names);
            if($old_uploaded_files != ""){
                $this->images = $old_uploaded_files . "," . $new_images;
            }else{
                $this->images = $new_images;
            }
        }elseif($old_uploaded_files != ""){
            $this->images = $old_uploaded_files;
        }
        
        $this->save(false);
    }

    public static function unlinkFile($uploaded_files)
    {
        //$dir1 = Yii::getAlias('@backend/web/uploads/ads_trash/');
        $dir2 = Yii::getAlias('@backend/web/uploads/ads/');

        if($uploaded_files != "")
        {
            $images = explode(",",$uploaded_files);
            foreach ($images as $value) {
                if(file_exists($dir2 . $value)){
                    unlink($dir2 . $value);
                }
            }
        }

        /*if(file_exists($dir1 . $file) && $file != null)
        {
            unlink($dir1 . $file);
        }
        elseif(file_exists($dir2 . $file) && $file != null)
        {
            $all_files = explode(",", $images);
            $index = array_search($file, $all_files);
            if($index !== false){
                unset($all_files[$index]);
            }
            unlink($dir2 . $file);
            return implode(",",$all_files);;
        }*/
    }

    public function getStar($favorites)
    {
        if(Yii::$app->user->identity->id != null) return false;

        foreach ($favorites as $value) {
            if($value->field_id == $this->id && Yii::$app->user->identity->id == $value->user_id) return true;
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

    public function getPromotionList()
    {
        $result = [];
        $aboutCompany = AboutCompany::findOne(1);
        $premiumCount = Ads::find()->where(['premium' => 1, 'category_id' => $this->category_id])->count();
        $topCount = Ads::find()->where(['top' => 1, 'category_id' => $this->category_id])->count();

        $promotions = Promotions::find()->all();
        //$idList = [];
        foreach ($promotions as $value) {

            if($value->premium == 1 && !$this->premium) {
                if($premiumCount >= $aboutCompany->premium_ads_count) {
                    $text = Yii::t('app', "Pullik xizmat vaqtinchalik mavjud emas. Administratorga murojaat qiling");
                    $status = 2;
                }
                else {
                    $text = $value->text;
                    $status = 1;
                }
            }
            if($value->premium == 1 && $this->premium) {
                $text = Yii::t('app', "Siz bu pullik xizmatni sotib olgansiz. Muddat tugashini kuting");
                $status = 3;
            }

            if($value->top == 1 && !$this->top) {
                if($topCount >= $aboutCompany->top_ads_count) {
                    $text = Yii::t('app', "Pullik xizmat vaqtinchalik mavjud emas. Administratorga murojaat qiling");
                    $status = 2;
                }
                else {
                    $text = $value->text;
                    $status = 1;
                }
            }

            if($value->top == 1 && $this->top) {
                $text = Yii::t('app', "Siz bu pullik xizmatni sotib olgansiz. Muddat tugashini kuting");
                $status = 3;
            }

            $result [] = [
                'id' => $value->id,
                'getImage' => $value->getImage('main_page'),
                'name' => $value->name,
                'text' => $text,
                'price' => $value->price,
                'status' => $status,
            ];
            //if($value->premium == 1 && !$this->premium) $idList [] = $value->id;
            //if($value->top == 1 && !$this->top) $idList [] = $value->id;
            //return Promotions::find()->where(['in', 'id', $idList])->all();
        }
        return $result;
    }
}
