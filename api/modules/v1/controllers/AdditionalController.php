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

    // Categoriyalar va SubCategorilar ro'yxati , parametr kelmaydi
     public function actionCategorySubList()
    {
        $category = Category::find()->all();
        $subCategories = Subcategory::find()->all();
        $result = []; $lang = "kr";
        if(Yii::$app->getRequest()->getBodyParams()['lang'] != null) {
            $lang = Yii::$app->getRequest()->getBodyParams()['lang'];
        }

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
                    'adsCount'=>$value->getCountCategory(),
                    'image' => $path,
                    'subCategory' => $value->getSubCategoryList($value, $subCategories),
                ];
            }
            else {
                $title = $value->getTitleTranslates($value, $lang, 'title');
                $result [] = [
                    'id' => $value->id,
                    'title' => $title,
                    'adsCount'=>$value->getCountCategory(),
                    'image' => $path,
                    'subCategory' => $value->getSubCategoryList($value, $subCategories),
                ];
            }
        }
            return $result;
    }
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

    //  Ads categoriya, sub, price, region.. jadvalidan qidirish sortirovka qilish
    public function actionSearchCategory($page = 0)
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $step = 1;
        $lang = "kr";
        if($body['lang'] != null) {
            $lang = $body['lang'];
        }

        $query = Ads::find();
        $result = Ads::getSearchAds($page, $query, $lang, $body, $step);
        return $result;
    }

    public function  actionAdsPremium($page = 0 )
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $step = 2;
        $lang = "kr";
        if($body['lang'] != null) {
            $lang = $body['lang'];
        }

        $query = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->andFilterWhere(['ads.premium' => 1])
            ->andFilterWhere(['ads.status' => 1]);

        $result = Ads::getSearchAds($page, $query, $lang, $body, $step);
        return $result;
    }
    public function  actionAdsNew($page = 0 )
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $step = 2;
        $lang = "kr";
        if($body['lang'] != null) {
            $lang = $body['lang'];
        }

        $query = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->andFilterWhere(['ads.date_cr' => date('Y-m-d')])
            ->andFilterWhere(['ads.status' => 1]);

        $result = Ads::getSearchAds($page, $query, $lang, $body, $step);

        return $result;
    }

    public function actionAdsTrusted($page = 0)
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $step = 2;
        $lang = "kr";
        if($body['lang'] != null) {
            $lang = $body['lang'];
        }
        $adsId = [];
        $adsId = UsersBall::getTrustedAds();

        $query = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->where(['in', 'ads.id', $adsId]);

        $result = Ads::getSearchAds($page, $query, $lang, $body, $step);
        return $result;
    }

    public function actionNews( $page = 0 )
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $lang = "kr";
        if($body['lang'] != null) {
            $lang = $body['lang'];
        }

        $query = News::find()->orderBy(['id' => SORT_DESC]);
        $result = News::getAllNewsList($page, $query, $lang);
        return $result;

    }

}