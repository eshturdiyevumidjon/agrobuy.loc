<?php

namespace backend\models;

use Yii;
use frontend\models\Sessions;
use yii\web\UploadedFile;

/**
 * This is the model class for table "banners".
 *
 * @property int $id
 * @property string $title Заголовок
 * @property string $text Текст
 * @property string $link Ссылка
 * @property string $image Фото
 * @property int $type Тип
 */
class Banners extends \yii\db\ActiveRecord
{
    public $translation_title;
    public $translation_text;
    public $trash;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banners';
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['text','title','link'],'required'],
            [['text'], 'string'],
            [['trash'], 'file'],
            [['translation_text','translation_title'],'safe'],
            [['title', 'link', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' =>  'Заголовок',
            'text' =>   'Текст',
            'link' =>   'Ссылка',
            'image' =>  'Фотография',
            'trash' =>  'Картинка',
        ];
    }
    public static function NeedTranslation()
    {
        return [
            'title'=>'translation_title',
            'text'=>'translation_text',
        ];
    }
    public function getImage($for='_form')
    {
        $adminka = 'admin';
        if($for=='_form')
        return $this->image ? '<img style="width:100%;border-radius:10%;" src="/'.$adminka.'/uploads/banners/' . $this->image .'">' : '<img style="width:100%; max-height:300px;border-radius:10%;" src="/'.$adminka.'/uploads/noimg.jpg">';
        if($for=='_columns')
           return $this->image  ? '<img style="width:60px; border-radius:10%;" src="/'.$adminka.'/uploads/banners/' . $this->image .' ">' : '<img style="width:60px;" src="/'.$adminka.'/uploads/noimg.jpg">';
    }


    public function upload()
    {
        $this->trash = UploadedFile::getInstance($this,'trash');
        if(!empty($this->trash))
        {
            $name = $this->id . '-' . time();
            $this->trash->saveAs('uploads/banners/' . $name.'.'.$this->trash->extension);
            Yii::$app->db->createCommand()->update('banners', ['images' => $name.'.'.$this->trash->extension], [ 'id' => $this->id ])->execute();
        }
    }


    public static function getTranslates($news_all)
    {
        $news  = [];
        $session = new Sessions();
        foreach ($news_all as  $value) {
                if(Yii::$app->language == 'ru'){
                        $news[] = [
                        'id' => $value->id,
                        'title' => $value->title,
                        'text' => $value->text,
                        'image' => $value->image,
                        'link' => $value->link,
                    ];
                }
                else {
                        $title = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'title');
                        $text = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'text');
                        $news[] = [
                        'id' => $value->id,
                        'title' => $title,
                        'text' => $text,
                        'image' => $value->image,
                        'link' => $value->link,
                    ];
                    
                }
        }
        return $news;
    }

    public static function getAllBannersList()
    {
        $session = new Sessions();
        $banners = Banners::find()->all();
        $result = [];
        $siteName = Yii::$app->params['siteName'];

        foreach ($banners as $value) {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/banners/' . $value->image) || $value->image == null) {
                $path = $siteName . '/backend/web/img/no-logo.png';
            } 
            else {
                $path = $siteName . '/backend/web/uploads/banners/' . $value->image;
            }
            if(Yii::$app->language == 'kr') {
                $result [] = [
                    'id' => $value->id,
                    'title' => $value->title,
                    'text' => $value->text,
                    'image' => $path,
                    'link' => $value->link,
                ];
            }
            else {
                $title = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'title');
                $text = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'text');
                $result [] = [
                    'id' => $value->id,
                    'title' => $title,
                    'text' => $text,
                    'image' => $path,
                    'link' => $value->link,
                ];
            }
        }

        return $result;
    }
}