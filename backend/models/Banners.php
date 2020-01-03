<?php

namespace backend\models;

use Yii;

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
            'title' => Yii::t('app','Title'),
            'text' => Yii::t('app','Text'),
            'link' => Yii::t('app','Link'),
            'image' => Yii::t('app','Image'),
            'trash' => Yii::t('app','Image'),
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
        return $this->image ? '<img style="width:100%;border-radius:10%;" src="/'.$adminka.'/uploads/banners/' . $this->image .'">' : '<img style="width:100%; max-height:300px;border-radius:10%;" src="/'.$adminka.'/uploads/noimg.jpg">';
        if($for=='_columns')
           return $this->image  ? '<img style="width:60px; border-radius:10%;" src="/'.$adminka.'/uploads/banners/' . $this->image .' ">' : '<img style="width:60px;" src="/'.$adminka.'/uploads/noimg.jpg">';
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

    public static function getTranslates($news_all)
    {
        $news  = [];
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
                        $title = Banners::TranslatesTitle($value, Yii::$app->language);
                        $text = Banners::TranslatesText($value, Yii::$app->language);
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
}