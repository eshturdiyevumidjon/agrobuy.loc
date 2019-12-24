<?php

namespace backend\models;

use Yii;
use backend\models\SubCategories;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string|null $name Наименование
 *
 * @property Groups[] $groups
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
         return [
            [['title', 'image'], 'string', 'max' => 255],
            ['title','required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Наименование',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Groups::className(), ['category_id' => 'id']);
    }

     public function getSubCategoryList()
    {
        $query = SubCategories::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $query->andFilterWhere(['category_id' => $this->id]);
        return $dataProvider;
    }

    public function getImage($for='_form')
    {
        $adminka = Yii::$app->params['adminka'];
        if($for=='_form')
        return $this->image != null ? '<img style="width:100%;border-radius:10%;" src="/'.$adminka.'uploads/category/' . $this->image .'">' : '<img style="width:100%; max-height:300px;border-radius:10%;" src="/'.$adminka.'uploads/noimg.jpg">';
        if($for=='_columns')
           return $this->image != null ? '<img style="width:60px; border-radius:10%;" src="/'.$adminka.'uploads/category/' . $this->image .' ">' : '<img style="width:60px;" src="/'.$adminka.'uploads/noimg.jpg">';
    }

}
