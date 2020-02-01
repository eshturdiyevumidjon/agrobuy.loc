<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "about_company".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $logo Лого
 * @property string|null $mail E-mail
 * @property string|null $phone Телефон
 */
class AboutCompany extends \yii\db\ActiveRecord
{
     public $image;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'about_company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'logo', 'mail', 'phone'], 'string', 'max' => 255],
            [['image'],'safe'],
            [['view_banners'],'integer'],
            [['address'],'string'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' =>'Наименование',
            'address' => 'Адрес',
            'logo' => 'Лого',
            'mail' => 'E-mail',
            'phone' => 'Телефон',
            'view_banners' => "Банныеры вкл/отк",
        ];
    }

    public function upload()
    {
        if(!empty($this->image))
        {   
            if(file_exists('uploads/about-company/'.$this->logo) && $this->logo != null)
            {
              unlink('uploads/about-company/'.$this->logo);
            }

            $this->image->saveAs('uploads/about-company/'.$this->image->baseName.'.'.$this->image->extension);
            Yii::$app->db->createCommand()->update('about_company', ['logo' => $this->image->baseName.'.'.$this->image->extension], [ 'id' => $this->id ])->execute();
        }
    }
}
