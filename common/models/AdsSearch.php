<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Ads;
use frontend\models\Sessions;

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
            [['id', 'user_id', 'type', 'category_id', 'subcategory_id', 'currency_id', 'region_id', 'district_id', 'status', 'is_checked'], 'integer'],
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
            'is_checked' => $this->is_checked,
            'status' => $this->status,
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
        $query = Ads::find()->joinWith(['category', 'user', 'currency'])->where(['ads.status' => 1]);
        $session = new Sessions();
        if(isset($get['sortingAds'])) {
            $sortingAds = $session->setSortingAds($get['sortingAds']);
        }
        else $sortingAds = $session->setSortingAds();
        if($sortingAds == 'date') $sort = [ 'date_cr' => SORT_ASC ];
        else $sort = [ 'price' => SORT_ASC ];

        if(isset($get['type'])) {
            $type = $session->getAdsType($get['type']);
        }
        else $type = $session->getAdsType();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => $sort,
            ],
        ]);

        if(isset($get['category'])) {
            $query->andFilterWhere([
                'ads.category_id' => $get['category'],
            ]);
        }

        if(isset($get['region'])) {
            $query->andFilterWhere([
                'ads.region_id' => $get['region'],
            ]);
        }

        if(isset($get['sub'])) {
            $query->andFilterWhere([
                'ads.subcategory_id' => $get['sub'],
            ]);
        }

        $query->andFilterWhere([ 'ads.type' => $type, ]);

        if(isset($get['text'])) {
            $query->andFilterWhere(['like', 'ads.title', $get['text']]);
        }

        return $dataProvider;
    }

    public function filtrMyAds($identity)
    {
        $query = Ads::find()
            ->joinWith(['category', 'user', 'currency', 'usersCatalogs'])
            ->where(['ads.user_id' => $identity->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    public function filtrMyFavorites($favId)
    {
        $query = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->where(['in', 'ads.id', $favId])
            ->andWhere(['ads.status' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }

    public function usersCatalogAds($usersCatalog, $get = null)
    {
        $adsID = [];
        foreach ($usersCatalog as $cat) { 
            $adsID [] = $cat->ads_id;
        }

        $query = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->where(['in', 'ads.id', $adsID]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if(isset($get['category'])) {
            $query->andFilterWhere([
                'ads.category_id' => $get['category'],
            ]);
        }

        if(isset($get['region'])) {
            $query->andFilterWhere([
                'ads.region_id' => $get['region'],
            ]);
        }

        if(isset($get['text'])) {
            $query->andFilterWhere(['like', 'ads.title', $get['text']]);
        }

        return $dataProvider;
    }

}
