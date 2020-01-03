<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Ads;

/**
 * AdsSearch represents the model behind the search form about `common\models\Ads`.
 */
class AdsSearch extends Ads
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'type', 'category_id', 'subcategory_id'], 'integer'],
            [['title', 'images', 'city_name', 'text', 'unit_price', 'treaty', 'date_cr'], 'safe'],
            [['price', 'old_price'], 'number'],
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
        $query = Ads::find();

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
            'user_id' => $this->user_id,
            'type' => $this->type,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'date_cr' => $this->date_cr,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'images', $this->images])
            ->andFilterWhere(['like', 'city_name', $this->city_name])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'unit_price', $this->unit_price])
            ->andFilterWhere(['like', 'treaty', $this->treaty]);

        return $dataProvider;
    }
}
