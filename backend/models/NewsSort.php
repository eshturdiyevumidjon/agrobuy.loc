<?php

namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "news_sort".
 *
 * @property int $id
 * @property int|null $news_id Новости
 * @property string|null $name Название
 * @property string|null $sort_name Сорт
 * @property string|null $weight Вес плода
 * @property string|null $productivity Урожайность
 *
 * @property News $news
 */
class NewsSort extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_sort';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_id'], 'integer'],
            [['name', 'sort_name'], 'required'],
            [['name', 'sort_name', 'weight', 'productivity', 'five', 'six'], 'string', 'max' => 255],
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
            'name' => '0',
            'sort_name' => '1',
            'weight' => '2',
            'productivity' => '3',
            'five' => '4',
            'six' => '5',
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

    public function search($params, $id)
    {
        $query = NewsSort::find()->where(['news_id' => $id]);

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
            ->andFilterWhere(['like', 'sort_name', $this->sort_name])
            ->andFilterWhere(['like', 'weight', $this->weight])
            ->andFilterWhere(['like', 'productivity', $this->productivity]);

        return $dataProvider;
    }
}
