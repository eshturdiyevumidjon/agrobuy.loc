<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\News;

/**
 * NewsSearch represents the model behind the search form about `backend\models\News`.
 */
class NewsSearch extends News
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'data_type'], 'integer'],
            [['title', 'text', 'date', 'image', 'video', 'video_title', 'sort_title', 'sort_items', 'landing_title', 'landing_text', 'important', 'growing_title', 'growing_text', 'growing_items', 'description', 'in_photo'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = News::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'video' => $this->video,
            'video_title' => $this->video_title,
            'sort_title' => $this->sort_title,
            'sort_items' => $this->sort_items,
            'landing_title' => $this->landing_title,
            'landing_text' => $this->landing_text,
            'important' => $this->important,
            'growing_title' => $this->growing_title,
            'growing_text' => $this->growing_text,
            'growing_items' => $this->growing_items,
            'description' => $this->description,
            'data_type' => $this->data_type,
            'in_photo' => $this->in_photo,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
