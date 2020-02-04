<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Promotions;

/**
 * PromotionsSearch represents the model behind the search form about `backend\models\Promotions`.
 */
class PromotionsSearch extends Promotions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'days', 'discount'], 'integer'],
            [['name', 'text', 'premium', 'top', 'image'], 'safe'],
            [['price'], 'number'],
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
        $query = Promotions::find();

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
            'price' => $this->price,
            'days' => $this->days,
            'image' => $this->image,
            'discount' => $this->discount,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'premium', $this->premium])
            ->andFilterWhere(['like', 'top', $this->top]);

        return $dataProvider;
    }
}
