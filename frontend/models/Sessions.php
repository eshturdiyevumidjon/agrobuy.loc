<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use backend\models\Settings;
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


}
