<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AdvertisingItems;

/**
 * AdvertisingItemsSearch represents the model behind the search form about `backend\models\AdvertisingItems`.
 */
class AdvertisingItemsSearch extends AdvertisingItems
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'advertising_id', 'type'], 'integer'],
            [['title', 'text', 'link', 'file'], 'safe'],
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
        $query = AdvertisingItems::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'advertising_id' => $this->advertising_id,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'file', $this->file]);

        return $dataProvider;
    }
}
