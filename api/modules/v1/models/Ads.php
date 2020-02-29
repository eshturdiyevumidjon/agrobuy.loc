<?php
namespace api\modules\v1\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use api\modules\v1\models\Currency;
use api\modules\v1\models\Reyting;
use api\modules\v1\models\Subcategory;
use api\modules\v1\models\UsersReyting;
use yii\data\ActiveDataProvider;

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

    public static function getSearchAds($page,$query,$lang,$body)
    {
        $array = [];
        $defaultPageSize = \Yii::$app->params['defaultPageSize'];
        $v1 = Yii::$app->params['v1'];
        $cont = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;
        $url = $v1 . $cont . '/' . $action;

        $category = $body['category'];
        $sub = $body['sub'];
        $type = $body['type'];
        $text = $body['text'];
        $region = $body['region'];
        $price_to = $body['price_to'];
        $price_do = $body['price_do'];
        $sortingAds = $body['sortingAds']; 

        $sort = [ 'id' => SORT_ASC ];
        if(isset($sortingAds)){
             if($sortingAds == 'date') $sort = [ 'date_cr' => SORT_ASC ];
            else $sort = [ 'price' => SORT_ASC ];
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $defaultPageSize,
                'page' => $page,
            ],
            'sort' => [
                'defaultOrder' => $sort,
            ],
        ]);

        if( $category != null ){
            $query->andFilterWhere([
                'category_id'=>$category,
            ]);
        }
        if( $sub != null ){
            $query->andFilterWhere([
                'subcategory_id'=>$sub,
            ]);
        }

        if( $step == 1)
        {
            if( isset($type) ){
            $query->andFilterWhere([
                'type'=>$type,
            ]);
            }
            else {
               $query->andFilterWhere([
                    'type'=>2,
                ]); 
            }
        }

        // poisk
        if(isset($region)) {
            $query->andFilterWhere([
                'ads.region_id' => $region,
            ]);
        }

        if(isset($text)) {
            $query->andFilterWhere(['like', 'ads.title', $text]);
        }

        if(isset($price_to) and isset($price_do)) {
            $query->andFilterWhere(['between', 'price', $price_to,$price_do]);
        }

        foreach ($dataProvider->getModels() as $value) {
            $array [] = [
                'id' => $value->id,
                'title' => $value->title,
                'type' => $value->getTypeDescription(),
                'old_price' => ($value->old_price != null) ? $value->price." ".$value->currency->name : "",
                'price' => $value->price." ".$value->currency->name,
                'address' =>$value->getAddress(),
                'region' => $value->region->name,
                'district' => $value->district->name,
                'category' => $value->category->getTitleTranslates($value->category, $lang, 'title'),
                'subcategory' => $value->category->getNameTranslates($value->subcategory, Yii::$app->language,'name'),
                'text' => $value->text,
                'reyting' => $value->user->getReyting(),
                'confidence' => $value->user->getStarCount()."/"."5",
                'date_cr' => $value->date_cr,
                'premium' => $value->premium,
            ];
        }

        $next = null;
        $nextDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $defaultPageSize,
                'page' => $page + 1,
            ]
        ]);
        if($nextDataProvider->getCount() > 0) $next = $url . "?page=".($page + 1);

        $previous = null;
        if($page > 0) {
            $previousDataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'defaultPageSize' => $defaultPageSize,
                    'page' => $page - 1,
                ]
            ]);
            if($previousDataProvider->getCount() > 0) $previous = $url . "?page=".($page - 1);
        }

        return [
            'page' => (integer)$page,
            'count' => $dataProvider->getCount(),
            //'max_page' => (integer) ($dataProvider->getTotalCount() / $defaultPageSize),
            'nextPage' => $next,
            'previousPage' => $previous,
            'ads' => $array,
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

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getComplaints()
    // {
    //     return $this->hasMany(Complaints::className(), ['ads_id' => 'id']);
    // }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getUsersCatalogs()
    // {
    //     return $this->hasMany(UsersCatalog::className(), ['ads_id' => 'id']);
    // }

    public function getType()
    {
        return [
            1 => "Куплю",
            2 => "Продам",
        ];
    }

    public function getTypeDescription()
    {
        switch ($this->type) {
            case 1: return "Куплю";
            case 2: return "Продам";
            default: return "Неизвестно";
        }
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
