<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "about_company".
 *
 * @property int $id
 * @property string|null $logo Лого
 * @property string|null $project_name Наимование
 * @property string|null $phone Телефон
 * @property string|null $link Линк
 * @property string|null $telegram Телеграм
 * @property string|null $facebook Facebook
 * @property string|null $google Google
 * @property string|null $video Видео
 * @property string|null $email Email
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
            [['logo', 'project_name', 'phone', 'link', 'telegram', 'facebook', 'google', 'video', 'email'], 'string', 'max' => 255],
            [['image'],'safe'],
            [['project_name','phone'],'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'logo' => 'Лого',
            'image'=>'Лого',
            'project_name' => 'Наимование',
            'phone' => 'Телефон',
            'link' => 'Ссылка',
            'telegram' => 'Телеграм',
            'facebook' => 'Facebook',
            'google' => 'Google',
            'video' => 'Видео',
            'email' => 'Email',
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
