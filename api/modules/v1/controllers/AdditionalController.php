<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\web\Response;
use yii\filters\auth\CompositeAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\rest\ActiveController;
use api\modules\v1\models\Category;
use api\modules\v1\models\SubCategory;
use api\modules\v1\models\Ads;


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
        $subCategories = SubCategory::find()->all();
        $result = [];
        $siteName = Yii::$app->params['siteName'];
        foreach ($category as $value) {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/category/' . $value->image) || $value->image == null) {
                $path = $siteName . 'backend/web/img/no-images.png';
            } 
            else {
                $path = $siteName . 'backend/web/uploads/category/' . $value->image;
            }
            if(Yii::$app->language == 'kr') {
                $result [] = [
                    'id' => $value->id,
                    'title' => $value->title,
                    'count_category'=>$value->getCountCategory(),
                    'image' => $path,
                    'subCategory' => $value->getSubCategoryList($value, $subCategories),
                ];
            }
            else {
                $title = $value->getTitleTranslates($value, Yii::$app->language, 'title');
                $result [] = [
                    'id' => $value->id,
                    'title' => $title,
                    'count_category'=>$value->getCountCategory(),
                    'image' => $path,
                    'subCategory' => $value->getSubCategoryList($value, $subCategories),
                ];
            }
        }
            return $result;
    }

  
    
}
