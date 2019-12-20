<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Lang;
use backend\models\CompanyLanguage;

/**
 * LangSearch represents the model behind the search form about `backend\models\Lang`.
 */
class LangSearch extends Lang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'default', 'create', 'status', 'date_update', 'date_create'], 'integer'],
            [['url', 'local', 'name', 'image'], 'safe'],
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
        $user = Yii::$app->user->identity;
        if($user->id != 1) {
            $langs = \yii\helpers\ArrayHelper::getColumn(\backend\models\CompanyLanguage::find()->where(['company_id'=>$user->company_id])->all(),'language_id');

            $query = Lang::find()->where(['id' => $langs,'status'=>1]);
        } 

        else $query = Lang::find();  

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
            'default' => $this->default,
            'create' => $this->create,
            'status' => $this->status,
            'date_update' => $this->date_update,
            'date_create' => $this->date_create,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'local', $this->local])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
