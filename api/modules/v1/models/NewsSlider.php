<?php
namespace api\modules\v1\models;


use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "news_slider".
 *
 * @property int $id
 * @property int|null $news_id Новости
 * @property string|null $name Наименование
 * @property string|null $image Картинка
 * @property string|null $link Ссылка
 *
 * @property News $news
 */
class NewsSlider extends \yii\db\ActiveRecord
{
    public $imageFiles;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_slider';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_id'], 'integer'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 1],
            [['name', 'image', 'link'], 'string', 'max' => 255],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['news_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'Новости',
            'name' => 'Наименование',
            'image' => 'Картинка',
            'link' => 'Ссылка',
            'imageFiles' => 'Фото',
        ];
    }

    /**
     * Gets query for [[News]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }

    public function getImage()
    {
        $siteName = Yii::$app->params['siteName'];
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/news_slider/' . $this->image)) {
            return $siteName . '/backend/web/img/no-logo.png';
        } else {
            return $siteName . '/backend/web/uploads/news_slider/' . $this->image;
        }
    }

    public function search($params, $id)
    {
        $query = NewsSlider::find()->where(['news_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'news_id' => $this->news_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
