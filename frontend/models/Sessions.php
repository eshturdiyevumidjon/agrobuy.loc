<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use backend\models\Settings;
use backend\models\AboutCompany;
use yii\data\ActiveDataProvider;
use backend\models\Translates;
/*use yii\web\Cookie;*/

/**
 * Signup form
 */
class Sessions extends Model
{
    public function getTerms($item = null)
    {
        $session = Yii::$app->session;
        if($session['terms'] == null) {
            $terms = Settings::find()->where(['view_in_footerser_id' => 1])->orderBy('priority', SORT_ASC)->all();
            $session['terms'] = $terms;
        }
        if($item === null) {
            return $session['terms'];
        }
        else {
            if($item == 0){
                if(isset($session['terms'][$item])) return '<a href="/privacy?key=' . $session['terms'][$item]['key'] . '" class="privacy-policy">' . $session['terms'][$item]['name'] . '</a>';
                else return null;
            }
            else {
                if(isset($session['terms'][$item])) return '<a href="/privacy?key=' . $session['terms'][$item]['key'] . '" >' . $session['terms'][$item]['name'] . '</a>';
                else return null;
            }
        }
    }

    public function getCompany()
    {
        $session = Yii::$app->session;
        if($session['about_company'] == null) {
            $about_company = AboutCompany::findOne(1);
            $session['about_company'] = $about_company;
        }
        if($item === null) {
            return $session['about_company'];
        }
    }

    public function setTranslates()
    {
        $query = Translates::find()->all();

        /*$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);*/

        $session = Yii::$app->session;
        $session['translates'] = $query;
        //return $session['translates'];

        // echo "<pre>";
        // print_r($session['translates']);
        // echo "</pre>";
        // die;

        /*$query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'key', $this->key]);*/
    }

    public static function getAllTranslates($table_name, $value, $lang, $field)
    {
        $session = Yii::$app->session;

        if($session['translates'] === null) {
            $trans = Translates::find()
                ->where([
                    'table_name' => $table_name,
                    'field_id' => $value->id,
                    'field_name'=> $field, 
                    'language_code' => $lang
                ])
                ->one();

                if($trans == null){
                    $title = $value->{$field};
                }
                else $title = $trans->field_value;

            return $title;
        }
        else {
            foreach ($session['translates'] as $tr) {
                if($tr->table_name == $table_name && $tr->field_id == $value->id && $tr->field_name == $field && $tr->language_code == $lang) return $tr->field_value;
            }
            return $value->{$field};
        }

    }


}
