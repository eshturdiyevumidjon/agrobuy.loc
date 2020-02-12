<?php

namespace api\modules\v1\controllers;

use Yii;
/*use yii\web\Controller;*/
use yii\web\Response;
/*use yii\helpers\Url;*/
use yii\filters\auth\CompositeAuth;
/*use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;*/
use yii\filters\ContentNegotiator;
/*use yii\filters\AccessControl;*/
/*use yii\filters\VerbFilter;*/
use yii\filters\Cors;
use yii\rest\ActiveController;
use api\modules\v1\models\Category;
use api\modules\v1\models\SubCategory;


/**
 * Default controller for the `api` module
 */
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

     public function actionCategoriesList()
    {
        $array = [];
        $categories = Category::find()->all();
        foreach ($categories as $value) {
            $array [] = [
                'id' => $value->id,
                'title' => $value->title,
            ];
        }
        return $array;
    }

  
    
}
