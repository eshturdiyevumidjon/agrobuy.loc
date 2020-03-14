<?php
namespace api\modules\v1\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "advertising_items".
 *
 * @property int $id
 * @property int|null $advertising_id Рекламные баннеры
 * @property string|null $title Заголовок
 * @property string|null $text Текст
 * @property string|null $link Ссылка
 * @property int|null $type Тип рекламы
 * @property string|null $file Файл
 *
 * @property Advertisings $advertising
 */
class AdvertisingItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $imageFiles;
    public static function tableName()
    {
        return 'advertising_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['advertising_id', 'type', 'count', 'status', 'click_count', 'limit', 'view_count'], 'integer'],
            [['text'], 'string'],
            [['title'], 'required'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true,],
            [['title', 'link', 'file'], 'string', 'max' => 255],
            [['advertising_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertisings::className(), 'targetAttribute' => ['advertising_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'advertising_id' => 'Рекламные баннеры',
            'title' =>'Заголовок',
            'text' => 'Текст',
            'link' => 'Ссылка',
            'type' => 'Тип рекламы',
            'file' => 'Файл',
            'imageFiles' => 'Файл',
            'count' => 'Счетчик',
            'status' => 'Статус',
            'click_count' => 'Кол-во кликов',
            'limit' => 'Лимит',
            'view_count' => 'Кол-во просмотров',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertising()
    {
        return $this->hasOne(Advertisings::className(), ['id' => 'advertising_id']);
    }

    public function getImage()
    {
      
        $siteName = Yii::$app->params['siteName'];
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/reclama-advert/' . $this->file)) {
            return $siteName . '/backend/web/img/no-logo.png';
        } else {
            return $siteName . '/backend/web/uploads/reclama-advert/' . $this->file;
        }
    }

    public function getType()
    {
        return [
            1 => 'Фотография',
            2 => 'Видео',
        ];
    }

    public static function getAdvertisingItems($id)
    {   
        $array = [];
        $reklama = AdvertisingItems::find()
            ->joinWith('advertising')
            ->where(['advertising_id' => $id])
            ->orderBy(['rand()' => SORT_DESC])
            ->all();
        foreach ($reklama as $value) {
            $array [] = [
                'title' =>$value->title,
                'text' => $value->text,
                'link' => $value->link,
                'file' => $value->getImage(),
            ];
        }
        return $array;
    }
}
