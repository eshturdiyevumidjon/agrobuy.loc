<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\web\Response;
use yii\filters\auth\CompositeAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\rest\ActiveController;
use api\modules\v1\models\Category;
use api\modules\v1\models\Subcategory;
use api\modules\v1\models\Ads;
use api\modules\v1\models\Regions;
use api\modules\v1\models\Districts;
use api\modules\v1\models\UsersBall;
use api\modules\v1\models\News;
use api\modules\v1\models\Lang;
use api\modules\v1\models\User;
use api\modules\v1\models\Advertisings;
use api\modules\v1\models\AdvertisingItems;
use api\modules\v1\models\Currency;
use yii\web\NotFoundHttpException;


class AdditionalController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Users';
    public $enableCsrfValidation = false; 

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['corsFilter'] =  [
            'class' => Cors::className(),
            'cors'  => [
                'Origin'                           => ['*'],
                'Access-Control-Request-Method'    => ['POST', 'GET','PUT','DELETE','PATCH','OPTIONS'],
                'Access-Control-Request-Headers'   => ['*'],
                'Access-Control-Allow-Origin'      => ['*'], 
            ],
        ];        
       
        $behaviors['authenticator']['class'] = CompositeAuth::className();
        $behaviors['authenticator']['except'] = [ 'list', 'options'] ;   
         
        return $behaviors;
    }

    // -------------------------- tillar listi -----------------------------------------
    public function actionLanguageList()
    {
        $response = \Yii::$app->getResponse();
        $languages = Lang::getLanguages();

        $array = [];
        foreach ($languages as $key => $value) {
            $array [] = [
                'url' => $value->url,
                'local' => $value->local,
                'name' => $value->name,
                'image' => $value->image != null ? Yii::$app->params['adminSiteName'].'backend/web/flags/'.$value->image : "",
            ];
        }
        $response->setStatusCode(202);
        return $array;
    }

    // -----------Categoriyalar va SubCategorilar ro'yxati , parametr kelmaydi----------------
     public function actionCategorySubList()
    {
        $category = Category::find()->all();
        $subCategories = Subcategory::find()->all();
        $result = [];
        $body = Yii::$app->getRequest()->getBodyParams();
        $lang = $this->findLang($body['lang']);

        $siteName = Yii::$app->params['siteName'];
        foreach ($category as $value) {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/category/' . $value->image) || $value->image == null) {
                $path = $siteName . 'backend/web/img/no-images.png';
            } 
            else {
                $path = $siteName . 'backend/web/uploads/category/' . $value->image;
            }
            if($lang == 'kr') {
                $result [] = [
                    'id' => $value->id,
                    'title' => $value->title,
                    'adsCount'=> (int)$value->getCountCategory(),
                    'image' => $path,
                    'subCategory' => $value->getSubCategoryList($value, $subCategories),
                ];
            }
            else {
                $title = $value->getTitleTranslates($value, $lang, 'title');
                $result [] = [
                    'id' => $value->id,
                    'title' => $title,
                    'adsCount'=>(int)$value->getCountCategory(),
                    'image' => $path,
                    'subCategory' => $value->getSubCategoryList($value, $subCategories),
                ];
            }
        }
            return $result;
    }

    // --------------------------- Regin list ---------------------------
    public function actionRegion()
    {
        $region = Regions::find()->all();
        $districts = Districts::find()->all();
        $result = [];
        foreach ($region as $value) {
            $result [] = [
                'id' => $value->id,
                'name' => $value->name,
                'districts' => $value->getDistrictsList($value, $districts),
           ];
        }
        return $result;
    }

    //  -----------Ads categoriya, sub, price, region.. jadvalidan qidirish sortirovka qilish------
    public function actionSearchCategory($page = 0)
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $step = 1;
        $lang = $this->findLang($body['lang']);

        $query = Ads::find();
        $result = Ads::getSearchAds($page, $query, $lang, $body, $step);
        return $result;
    }

    // --------------------------------Premium kataloglar-------------------------------
    public function  actionAdsPremium($page = 0 )
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $step = 2;
        $lang = $this->findLang($body['lang']);

        $query = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->andFilterWhere(['ads.premium' => 1])
            ->andFilterWhere(['ads.status' => 1]);

        $result = Ads::getSearchAds($page, $query, $lang, $body, $step);
        return $result;
    }

    //  ---------------------------yangi kataloglar ro'yxati------------------------------
    public function  actionAdsNew($page = 0 )
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $step = 2;
        $lang = $this->findLang($body['lang']);

        $query = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->andFilterWhere(['ads.date_cr' => date('Y-m-d')])
            ->andFilterWhere(['ads.status' => 1]);

        $result = Ads::getSearchAds($page, $query, $lang, $body, $step);

        return $result;
    }

    // ----------------------------------ads, im daveryayut------------------------------------
    public function actionAdsTrusted($page = 0)
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $step = 2;
        $lang = $this->findLang($body['lang']);
        $adsId = [];
        $adsId = UsersBall::getTrustedAds();

        $query = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->where(['in', 'ads.id', $adsId]);

        $result = Ads::getSearchAds($page, $query, $lang, $body, $step);
        return $result;
    }

    // --------------------------------Yangiliklar--------------------------------
    public function actionNews( $page = 0 )
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $lang = $this->findLang($body['lang']);

        $query = News::find()->orderBy(['id' => SORT_DESC]);
        $result = News::getAllNewsList($page, $query, $lang);
        return $result;
    }

    // -------------------------------Cataloglarni kartichkasi----------------------------------
    public function actionAdsCard($id, $page = 0)
    {   
        
        $body = Yii::$app->getRequest()->getBodyParams();
        $lang = $this->findLang($body['lang']);
        $step = 2;
        $model = Ads::findOne($id);
        $user = $this->findAccess();
        if($model != null) {

            $query = Ads::find()
            ->joinWith(['category', 'user', 'currency', 'subcategory'])
            ->where(['like', 'subcategory.name', $model->subcategory->name])
            ->orderBy(['rand()' => SORT_DESC]);

            return [
                'user' =>$model->getAdsUserInformation($user),
                'card' => $model->getAds($lang),
                'similar_ads' => Ads::getSearchAds($page, $query, $lang, $body, $step),
            ];
        }
        else {
             throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    // -----------------------------Yangiliklar kartichkasi----------------------------
    public function actionNewsCard($id)
    {   
        $body = Yii::$app->getRequest()->getBodyParams();
        $lang = $this->findLang($body['lang']);
        Yii::$app->language = $lang;

        $model = News::findOne($id);
        if($model != null) {
            return $model->getNewsCard($lang);
        }
        else {
             throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    // -------------------------- reklama -----------------------------
    public function actionAdvertising($key = null)
    {   
        $body = Yii::$app->getRequest()->getBodyParams();
        $adv = Advertisings::find()->where(['key' => $body['key'] ])->one();
        return AdvertisingItems::getAdvertisingItems($adv->id);
    }

     // --------------------------CurrencyList -----------------------------
    public function actionCurrencyList($key = null)
    {   
        $currency = Currency::find()->asArray()->all();
        return $currency;
    }
    
    // -----------------------find lang-------------------------------
     protected function findLang($url)
    {   
        $model = Lang::find()->where(['url' => $url])->one();

        if ($model != null) {
            return $model->url;
        } else {
            return "kr";
        }
    }

    //-------------------  avtorizatsiayadan o'tgan usersni aniqlash  -------------------
    public function findAccess()
    {
        $array = explode(' ',\Yii::$app->getRequest()->getHeaders()['Authorization']);
        $nowUser = User::findIdentityByAccessToken($array[1]);
        if($nowUser != null) return $nowUser['id'];
        else return null;
    }

}