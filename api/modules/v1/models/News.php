<?php
namespace api\modules\v1\models;


use Yii;
use api\modules\v1\models\Translates;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;


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
    public $fone_file;
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
    public $translation_description;

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
            [['imageFiles', 'fone_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', ],
            [['text', 'sort_items', 'landing_text', 'important', 'growing_text', 'growing_items', 'description'], 'string'],
            [['date'], 'safe'],
            [['data_type'], 'integer'],
            [['title', 'image', 'video', 'video_title', 'sort_title', 'landing_title', 'growing_title', 'in_photo'], 'string', 'max' => 255],
            [['translation_text', 'translation_title', 'translation_sort_title', 'translation_sort_items', 'translation_landing_title', 'translation_landing_text', 'translation_important', 'translation_growing_title', 'translation_growing_text', 'translation_growing_items', 'translation_description'],'safe'],
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
            'description' => 'Описание',
            'data_type' => 'Тип',
            'in_photo' => 'Фото',
            'fone_file' => 'Картинка',
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

    // public function getNewsSorts()
    // {
    //     return $this->hasMany(NewsSort::className(), ['news_id' => 'id']);
    // }

    public function getType()
    {
        return ArrayHelper::map([
            ['id' => '1','type' => 'Видео',],
            ['id' => '2','type' => 'Картинка',], 
        ], 'id', 'type');
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
            'description' => 'translation_description',
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

    public static function getAllNewsList($page,$query,$lang)
    {
        $array = [];
        $defaultPageSize = \Yii::$app->params['defaultPageSize'];
        $v1 = Yii::$app->params['v1'];
        $cont = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;
        $url = $v1 . $cont . '/' . $action;

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


        $siteName = Yii::$app->params['siteName'];

        foreach ($dataProvider->getModels() as $value) {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/news/' . $value->image) || $value->image == null) {
                $path = $siteName . '/backend/web/img/no-logo.png';
            } 
            else {
                $path = $siteName . '/backend/web/uploads/news/' . $value->image;
            }
            if( $lang == 'kr') {
                $result [] = [
                    'id' => $value->id,
                    'title' => $value->title,
                    'text' => $value->text,
                    'image' => $path,
                    'date' => date('d.m.Y', strtotime($value->date)),
                ];
            }
            else {
                $title = $value->TranslatesTitle($value, $lang);
                $text = $value->TranslatesText($value, $lang);
                $result [] = [
                    'id' => $value->id,
                    'title' => $title,
                    'text' => $text,
                    'image' => $path,
                    'date' => date('d.m.Y', strtotime($value->date))
                ];
            }
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
            'news' => $result,
        ];
    }

}