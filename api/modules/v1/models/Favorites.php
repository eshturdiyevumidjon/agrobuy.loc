<?php
namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "favorites".
 *
 * @property int $id
 * @property int|null $user_id Пользователь
 * @property int|null $type Тип
 * @property int|null $date_cr Дата создание
 * @property string|null $field_id Значение
 *
 * @property Users $user
 */
class Favorites extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorites';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'date_cr'], 'integer'],
            [['date_cr'], 'safe'],
            [['field_id'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'type' => 'Тип',
            'date_cr' => 'Дата создание',
            'field_id' => 'Значение',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->date_cr = date('Y-m-d H:i:s');
        }
        
        return parent::beforeSave($insert);
    }
    //type = 1 bu adslarga yulduzcha qoyish

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public static function  CheckFavorites($id)
    {
        $model = Favorites::find()
            ->where(['field_id'=>$id])
            ->andWhere([ 'user_id'=>Yii::$app->user->identity->id,'type'=>1])->one();
        if($model != null)
        {
            $model->delete();
        }

        else {
            $model = new Favorites();
            $model->type = 1;
            $model->user_id = Yii::$app->user->identity->id;
            $model->field_id = $id;
            $model->save();
        }

        return true;
    }
}
