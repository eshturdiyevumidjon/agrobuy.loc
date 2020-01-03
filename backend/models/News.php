<?php

namespace backend\models;


use Yii;
use backend\models\Translates;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title Заголовок
 * @property string $text Текст
 * @property string $image Фон
 * @property string $date Дата
 */
class News extends \yii\db\ActiveRecord
{
    public $imageFiles;
    public $translation_title;
    public $translation_text;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }
   
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title','text'],'required'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 10],
            [['text'], 'string'],
            [['translation_text','translation_title'],'safe'],
            [['date'], 'safe'],
            [['title', 'image'], 'string', 'max' => 255],
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
        $adminka = Yii::$app->params['adminka'];
        
        if($for=='_form')
        return $this->image != null ? '<img style="width:100%;border-radius:10%;" src="/'.$adminka.'uploads/news/' . $this->image .'">' : '<img style="width:100%; max-height:300px;border-radius:10%;" src="/'.$adminka.'uploads/noimg.jpg">';
        if($for=='_columns')
           return $this->image != null ? '<img style="width:60px; border-radius:10%;" src="/'.$adminka.'uploads/news/' . $this->image .' ">' : '<img style="width:60px;" src="/'.$adminka.'uploads/noimg.jpg">';
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->date=Yii::$app->formatter->asDate(time(), 'php:Y-m-d');
        }
        else
        {
            $this->date=Yii::$app->formatter->asDate($this->date, 'php:Y-m-d'); 
        }
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->date=Yii::$app->formatter->asDate($this->date, 'php:d.m.Y'); 
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок ',
            'imageFiles' => 'Картинка',
            'text' => 'Текст',
            'image' => 'Фотография',
            'date' => 'Дата',
        ];
    }

    public static function TranslatesText($value, $lang)
    {
        $text = Translates::find()
            ->where(['table_name' => $value->tableName(),'field_id' => $value->id,'field_name'=>'text', 'language_code' => $lang])
            ->one()->field_value;

            if($text == null){
                $text = $value->text;
            }

        return $text;
    }

    public static function TranslatesTitle($value, $lang)
    {
        $title = Translates::find()
            ->where(['table_name' => $value->tableName(),'field_id' => $value->id,'field_name'=>'title', 'language_code' => $lang])
            ->one()->field_value;

            if($title == null){
                $title = $value->title;
            }

        return $title;
    }

    public static function getTranslates($news_all){
    $news  = [];
     foreach ($news_all as  $value) {
            if(Yii::$app->language == 'ru')
                {
                    $news[] = [
                    'id' => $value->id,
                    'title' => $value->title,
                    'text' => $value->text,
                    'image' => $value->image,
                    'date' => $value->date,
                ];
            }
            else {
                    $title = News::TranslatesTitle($value, Yii::$app->language);
                    $text = News::TranslatesText($value, Yii::$app->language);
                    $news[] = [
                    'id' => $value->id,
                    'title' => $title,
                    'text' => $text,
                    'image' => $value->image,
                    'date' => $value->date,
                ];
                
            }
        }
        return $news;
   }
}