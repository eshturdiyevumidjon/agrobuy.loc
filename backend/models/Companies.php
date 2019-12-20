<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "companies".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $phone Телефон
 * @property string|null $address Адрес
 * @property string|null $logo Лого
 * @property string|null $link Линк
 * @property string|null $cordinte_x Координата х
 * @property string|null $cordinate_y Координата у
 * @property int|null $type Тип
 *
 * @property Advertising[] $advertisings
 * @property CompanyLanguage[] $companyLanguages
 * @property Courses[] $courses
 * @property GroupsOffer[] $groupsOffers
 * @property Reyting[] $reytings
 * @property Users[] $users
 */
class Companies extends \yii\db\ActiveRecord
{   
    public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'companies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'logo','text'], 'string'],
            [['image'],'safe'],
            [['name','tariff_id'],'required'],
            [['tariff_id'], 'integer'],
            [['name', 'phone', 'link', 'coordinate_x', 'coordinate_y'], 'string', 'max' => 255],
             [['tariff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tariffs::className(), 'targetAttribute' => ['tariff_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'phone' => 'Телефон',
            'address' => 'Адрес',
            'logo' => 'Лого',
            'image' => 'Лого',
            'link' => 'Ссылка',
            'coordinate_x' => 'Координата х',
            'coordinate_y' => 'Координата у',
            'text' => 'Текст',
            'tariff_id'=>'Тариф',
            
        ];
    }

    public function upload()
    {
        if(!empty($this->image))
        {   
            if(file_exists('uploads/companies/'.$this->logo) && $this->logo != null)
          {
              unlink('uploads/companies/'.$this->logo);
          }

            $this->image->saveAs('uploads/companies/'.$this->image->baseName.'.'.$this->image->extension);
            Yii::$app->db->createCommand()->update('companies', ['logo' => $this->image->baseName.'.'.$this->image->extension], [ 'id' => $this->id ])->execute();
        }
    }


     public  function getTariffsList()
    {
        $tariffs = Tariffs::find()->all();
        return ArrayHelper::map($tariffs, 'id', 'name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisings()
    {
        return $this->hasMany(Advertising::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyLanguages()
    {
        return $this->hasMany(CompanyLanguage::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Courses::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupsOffers()
    {
        return $this->hasMany(GroupsOffer::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReytings()
    {
        return $this->hasMany(Reyting::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['company_id' => 'id']);
    }

    public function getTariff()
    {
        return $this->hasOne(Tariffs::className(), ['id' => 'tariff_id']);
    }
}
