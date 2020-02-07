<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use backend\models\Settings;
use backend\models\AboutCompany;
use yii\data\ActiveDataProvider;
use backend\models\Translates;
use backend\models\Advertisings;
use common\models\Regions;

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
                if(isset($session['terms'][$item])) return '<a href="/privacy?key=' . $session['terms'][$item]['key'] . '" class="privacy-policy">' . $this->getFooterLangName($session['terms'][$item]['key']) . '</a>';
                else return null;
            }
            else {
                if(isset($session['terms'][$item])) return '<a href="/privacy?key=' . $session['terms'][$item]['key'] . '" >' . $this->getFooterLangName($session['terms'][$item]['key']) . '</a>';
                else return null;
            }
        }
    }

    public function getFooterLangName($key)
    {
        if($key == 'terms_of_use') return Yii::t('app',"Foydalanuvchi shartnomasi");
        if($key == 'privacy_policy') return Yii::t('app',"Maxfiylik siyosati");
        if($key == 'quick_sale') return Yii::t('app',"Tez sotish");
        if($key == 'turbo') return Yii::t('app',"Turbo");
        if($key == 'premium') return Yii::t('app',"Pullik");
        if($key == 'vip') return Yii::t('app',"Vip");
        if($key == 'highlight_ads') return Yii::t('app',"Reklamalarni ajratib ko'rsatish");
        if($key == 'raising_ads') return Yii::t('app',"E'lonni yuqoriga chiqarish");
        if($key == 'extension_of_publication') return Yii::t('app',"Nashrni kengaytirish");
        if($key == 'ad_limit') return Yii::t('app',"E'lon cheklovi");
        if($key == 'transaction_rules') return Yii::t('app',"Bitim qoidalari");
    }

    public function getCompany()
    {
        $session = Yii::$app->session;
        if($session['about_company'] == null) {
            $about_company = AboutCompany::findOne(1);
            $session['about_company'] = $about_company;
        }
        return $session['about_company'];
    }

    public function setTranslates()
    {
        $translates = Translates::find()->all();
        $session = Yii::$app->session;
        $session['translates'] = $translates;
    }

    public function setSortingAds($sortingAds = null)
    {
        $session = Yii::$app->session;
        if($session['sortingAds'] == null) $session['sortingAds'] = 'price';
        if($sortingAds != null) {
            if($sortingAds == 'date' || $sortingAds == 'price') $session['sortingAds'] = $sortingAds;
            else $session['sortingAds'] = 'price';
        }
        return $session['sortingAds'];
    }

    public function getAdsType($ads_type = null)
    {
        $session = Yii::$app->session;
        if($session['ads_type'] == null) $session['ads_type'] = 1;
        if($ads_type != null) {
            if($ads_type == '1' || $ads_type == '2') $session['ads_type'] = $ads_type;
            else $session['ads_type'] = '1';
        }
        return $session['ads_type'];
    }

    public function getTranslates()
    {
        $session = Yii::$app->session;
        if($session['translates'] == null) {
            $translates = Translates::find()->all();
            $session['translates'] = $translates;
        }
        return $session['translates'];
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
                if($tr->table_name == $table_name && $tr->field_id == $value->id && $tr->field_name == $field && $tr->language_code == $lang){
                    if($tr->field_value == '') return $value->{$field};
                    else return $tr->field_value;
                } 
            }
            return $value->{$field};
        }

    }

    public function getMainAdv()
    {
        $session = Yii::$app->session;
        if($session['main_adv'] == null) {
            $adv = Advertisings::find()->where(['key' => 'main'])->one();
            $session['main_adv'] = $adv;
            return $session['main_adv'];
        }
        return $session['main_adv'];
    }

    public function getCatalogAdv()
    {
        $session = Yii::$app->session;
        if($session['catalog_adv'] == null) {
            $adv = Advertisings::find()->where(['key' => 'user_catalog'])->one();
            $session['catalog_adv'] = $adv;
            return $session['catalog_adv'];
        }
        return $session['catalog_adv'];
    }

    public function getSearchBigAdv()
    {
        $session = Yii::$app->session;
        if($session['search_big'] == null) {
            $adv = Advertisings::find()->where(['key' => 'search_big'])->one();
            $session['search_big'] = $adv;
            return $session['search_big'];
        }
        return $session['search_big'];
    }

    public function getSearchSmallAdv()
    {
        $session = Yii::$app->session;
        if($session['search_small'] == null) {
            $adv = Advertisings::find()->where(['key' => 'search_small'])->one();
            $session['search_small'] = $adv;
            return $session['search_small'];
        }
        return $session['search_small'];
    }

    public function getRegionsList()
    {
        $session = Yii::$app->session;
        if($session['regions'] == null) {
            $regions = Regions::find()->all();
            $session['regions'] = $regions;
            return $session['regions'];
        }
        return $session['regions'];
    }

    public function getCategoryName($categories, $cat_id, $sub_id)
    {
        foreach ($categories as $value) {
            if($value['id'] == $cat_id) {
                foreach ($value['subCategory'] as $sub) {
                    if($sub['id'] == $sub_id) return $value['title'] . ', ' . $sub['name'];
                }
                return $value['title'];
            }
        }

        return '';
    }


}
