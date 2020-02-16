<?php

namespace backend\models;

use Yii;
use backend\models\Translates;
use frontend\models\Sessions;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string|null $title Заголовок
 * @property string|null $text Текст
 * @property string|null $date Дата
 * @property string|null $image Фотография
 * @property string|null $video Видео
 * @property string|null $video_title Заголовок видео
 * @property string|null $sort_title Выбираем сорт
 * @property string|null $sort_items Пункты сорта
 * @property string|null $landing_title Посадка
 * @property string|null $landing_text Текст посадки
 * @property string|null $important Важно
 * @property string|null $growing_title Выращивание
 * @property string|null $growing_text Текст выращивании
 * @property string|null $growing_items Пункты выращивании
 *
 * @property NewsSlider[] $newsSliders
 * @property NewsSort[] $newsSorts
 */

class News extends \yii\db\ActiveRecord
{
    public $imageFiles;
    public $translation_title;
    public $translation_text;
    public $translation_sort_title;
    public $translation_sort_items;
    public $translation_landing_title;
    public $translation_landing_text;
    public $translation_important;
    public $translation_growing_title;
    public $translation_growing_text;
    public $translation_growing_items;

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
            [['text', 'sort_items', 'landing_text', 'important', 'growing_text', 'growing_items'], 'string'],
            [['date'], 'safe'],
            [['title', 'image', 'video', 'video_title', 'sort_title', 'landing_title', 'growing_title'], 'string', 'max' => 255],
            [['translation_text', 'translation_title', 'translation_sort_title', 'translation_sort_items', 'translation_landing_title', 'translation_landing_text', 'translation_important', 'translation_growing_title', 'translation_growing_text', 'translation_growing_items'],'safe'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'date' => 'Дата',
            'image' => 'Фотография',
            'video' => 'Видео',
            'video_title' => 'Заголовок видео',
            'sort_title' => 'Выбираем сорт',
            'sort_items' => 'Пункты сорта',
            'landing_title' => 'Посадка',
            'landing_text' => 'Текст посадки',
            'important' => 'Важно',
            'growing_title' => 'Выращивание',
            'growing_text' => 'Текст выращивании',
            'growing_items' => 'Пункты выращивании',
            'imageFiles' => 'Фото',
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->date = Yii::$app->formatter->asDate(time(), 'php:Y-m-d');
        }
        else {
            $this->date = Yii::$app->formatter->asDate($this->date, 'php:Y-m-d'); 
        }
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->date = Yii::$app->formatter->asDate($this->date, 'php:d.m.Y'); 
    }

    public function beforeDelete()
    {
        $slider = NewsSlider::find()->where(['news_id' => $this->id])->all();
        foreach ($slider as $value) {
            $value->delete();
        }

        $sort = NewsSort::find()->where(['news_id' => $this->id])->all();
        foreach ($sort as $value) {
            $value->delete();
        }

        return parent::beforeDelete();
    }

    /**
     * Gets query for [[NewsSliders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNewsSliders()
    {
        return $this->hasMany(NewsSlider::className(), ['news_id' => 'id']);
    }

    /**
     * Gets query for [[NewsSorts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNewsSorts()
    {
        return $this->hasMany(NewsSort::className(), ['news_id' => 'id']);
    }

    public static function NeedTranslation()
    {
        return [
            'title' => 'translation_title',
            'text' => 'translation_text',
            'sort_title' => 'translation_sort_title',
            'sort_items' => 'translation_sort_items',
            'landing_title' => 'translation_landing_title',
            'landing_text' => 'translation_landing_text',
            'important' => 'translation_important',
            'growing_title' => 'translation_growing_title',
            'growing_text' => 'translation_growing_text',
            'growing_items' => 'translation_growing_items',
        ];
    }

    public function getImage($for = '_form')
    {
        $adminka = Yii::$app->params['adminka'];
        
        if($for=='_form')
        return $this->image != null ? '<img style="width:100%;border-radius:10%;" src="/'.$adminka.'uploads/news/' . $this->image .'">' : '<img style="width:100%; max-height:250px;border-radius:10%;" src="/'.$adminka.'uploads/noimg.jpg">';
        if($for=='_columns')
           return $this->image != null ? '<img style="width:60px; border-radius:10%;" src="/'.$adminka.'uploads/news/' . $this->image .' ">' : '<img style="width:60px;" src="/'.$adminka.'uploads/noimg.jpg">';
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
        $session = new Sessions();
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
                    $title = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'title');
                    $text = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'text');
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

    public function getAllNewsList()
    {
        $session = new Sessions();
        $news = News::find()->orderBy(['id' => SORT_DESC])->all();
        $result = [];
        $siteName = Yii::$app->params['siteName'];

        foreach ($news as $value) {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/news/' . $value->image) || $value->image == null) {
                $path = $siteName . '/backend/web/img/no-logo.png';
            } 
            else {
                $path = $siteName . '/backend/web/uploads/news/' . $value->image;
            }
            if(Yii::$app->language == 'kr') {
                $result [] = [
                    'id' => $value->id,
                    'title' => $value->title,
                    'text' => $value->text,
                    'image' => $path,
                    'date' => date('d.m.Y', strtotime($value->date))
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
                    'date' => date('d.m.Y', strtotime($value->date))
                ];
            }
        }
        return $result;
    }

    public function getOneModel()
    {
        $session = new Sessions();
        $siteName = Yii::$app->params['siteName'];
        $value = $this;

            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/news/' . $value->image) || $value->image == null) {
                $path = $siteName . '/backend/web/img/no-logo.png';
            } 
            else {
                $path = $siteName . '/backend/web/uploads/news/' . $value->image;
            }
            if(Yii::$app->language == 'kr') {
                return [
                    'id' => $value->id,
                    'video' => $value->video,
                    'video_title' => $value->video_title,
                    'title' => $value->title,
                    'text' => $value->text,
                    'image' => $path,
                    'sort_title' => $sort_title,
                    'sort_items' => explode(',', $sort_items),
                    'landing_title' => $landing_title,
                    'landing_text' => $landing_text,
                    'important' => $important,
                    'growing_title' => $growing_title,
                    'growing_text' => $growing_text,
                    'growing_items' => explode(',', $growing_items),
                    'date' => date('d.m.Y', strtotime($value->date))
                ];
            }
            else {
                $title = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'title');
                $text = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'text');
                $sort_title = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'sort_title');
                $sort_items = explode(',', $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'sort_items'));
                $landing_title = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'landing_title');
                $landing_text = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'landing_text');
                $important = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'important');
                $growing_title = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'growing_title');
                $growing_text = $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'growing_text');
                $growing_items = explode(',', $session->getAllTranslates($value->tableName(), $value, Yii::$app->language, 'growing_items'));

                return [
                    'id' => $value->id,
                    'video' => $value->video,
                    'video_title' => $value->video_title,
                    'title' => $title,
                    'text' => $text,
                    'image' => $path,
                    'sort_title' => $sort_title,
                    'sort_items' => $sort_items,
                    'landing_title' => $landing_title,
                    'landing_text' => $landing_text,
                    'important' => $important,
                    'growing_title' => $growing_title,
                    'growing_text' => $growing_text,
                    'growing_items' => $growing_items,
                    'date' => date('d.m.Y', strtotime($value->date))
                ];
            }
    }
}