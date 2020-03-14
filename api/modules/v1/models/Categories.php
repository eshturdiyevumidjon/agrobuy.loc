<?php

namespace api\modules\v1\models;

use api\base\AppActiveQuery;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name Наименование
 * @property int $parent_id Родителкая категория
 * @property int $sorting Сортировка
 * @property string $image Фото
 * @property double $price Цена
 * @property int $company_id Компания
 *
 * @property Companies $company
 */
class Categories extends \yii\db\ActiveRecord
{
    public $img;
    public $names;
    public $count_files;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'sorting', 'company_id'], 'integer'],
            [['price','sorting','name'],'required'],
            [['img'],'file'],
            ['count_files','ValidateFiles'],
            [['price'], 'number' ,'min' => 0],
            [['name', 'image'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companies::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    public function validateFiles($attribute)
    { 
        if($this->count_files == 0) $this->addError($attribute, 'Картинка не должна быть пустой');       
    }

    public function behaviors()
    {
        if(Yii::$app->user->identity){
            return [
                [
                    'class' => BlameableBehavior::class,
                    'createdByAttribute' => 'company_id',
                    'updatedByAttribute' => null,
                    'value' => function($event) {
                        return Yii::$app->user->identity->company_id;
                    },
                ],
            ];
        }
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        if(Yii::$app->user->isGuest == false)
        {
            if(Yii::$app->user->identity->company->type === 2)
            {
                $companyId = Yii::$app->user->identity->company_id;
            }
            else $companyId = null;
        } 
        else $companyId = null;

        return new AppActiveQuery(get_called_class(), [
           'companyId' => $companyId,
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function findOne($condition)
    {
        $model = parent::findOne($condition);
        if(Yii::$app->user->isGuest == false) 
        {
            if(Yii::$app->user->identity->company->type === 2)
            {
                $companyId = Yii::$app->user->identity->company_id;
                if($model->company_id != $companyId){
                    throw new ForbiddenHttpException('Доступ запрещен');
                }
            }
        }
        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'parent_id' => 'Родителкая категория',
            'sorting' => 'Сортировка',
            'image' => 'Фото',
            'price' => 'Цена',
            'company_id' => 'Компания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Companies::className(), ['id' => 'company_id']);
    }

    public function getAllParentCategories()
    {
        return self::find()->where(['parent_id' => 0])->all();
    }

    public function isHaveSubCategories()
    {
        return self::find()->where(['parent_id' => $this->id])->count() > 0;
    }

    public function getAllSubCategories()
    {
        return self::find()->where(['parent_id' => $this->id])->all();
    }

    //rasm yuklash 
    public function uploadFile(UploadedFile $file)
    {
        $dir = Yii::getAlias('@web').'uploads/categories/';
        if($this->image != null && file_exists($dir.$this->image))
        {
            unlink($dir.$this->image);
        }
        $name = $this->id."-".time().".".$file->extension;
        $file->saveAs($dir.$name);
        $this->image = $name;
        return $this->save(false);
    }

    public function getImgAddress()
    {
        $dir = Yii::getAlias('@web').'uploads/categories/';
        if($this->image != null && file_exists($dir.$this->image))
        {
            $dir = Yii::getAlias('@web').'/uploads/categories/';
            return $dir.$this->image;
        }else{
            $dir2 = Yii::getAlias('@web').'/uploads/';
            return $dir2.'noimg.jpg';
        }

    }

    public function printImage($mashtab)
    {
        $width = 100;
        if($mashtab){
            $width /= $mashtab;
        }
        return "<img src='".$this->getImgAddress()."' style='width:".$width."%;'>";
    }
    
}
