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
            [['id', 'user_id', 'type', 'category_id', 'subcategory_id', 'currency_id', 'region_id', 'district_id'], 'integer'],
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
            'currency_id' => $this->currency_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'images', $this->images])
            ->andFilterWhere(['like', 'city_name', $this->city_name])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'unit_price', $this->unit_price])
            ->andFilterWhere(['like', 'treaty', $this->treaty]);

        return $dataProvider;
    }

    public function searchByCatalog($params, $id)
    {
        $catalog = UsersCatalog::find()->where(['user_id' => $id])->all();
        $idList = [];
        foreach ($catalog as $value) {
            $idList [] = $value->ads_id;
        }
        $query = Ads::find()->where(['id' => $idList]);

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

    public function searchByUser($params, $id)
    {
        $query = Ads::find()->where(['user_id' => $id]);

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

    public function searchByFavorites($params, $id)
    {
        $favorites = Favorites::find()->where(['type' => 1, 'user_id' => $id])->all();
        $idList = [];
        foreach ($favorites as $value) {
            $idList [] = $value->field_id;
        }
        $query = Ads::find()->where(['id' => $idList]);

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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function filtr($get)
    {
        $query = Ads::find()->joinWith(['category', 'user', 'currency']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if(isset($get['category'])) {
            $query->andFilterWhere([
                'category_id' => $get['category'],
            ]);
        }

        if(isset($get['region'])) {
            $query->andFilterWhere([
                'region_id' => $get['region'],
            ]);
        }

        if(isset($get['sub'])) {
            $query->andFilterWhere([
                'subcategory_id' => $get['sub'],
            ]);
        }

        if(isset($get['text'])) {
            $query->andFilterWhere(['like', 'title', $get['text']]);
        }

        return $dataProvider;
    }

}
