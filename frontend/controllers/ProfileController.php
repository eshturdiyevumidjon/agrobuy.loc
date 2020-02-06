<?php

namespace frontend\controllers;

use Yii;
use yii\web\HttpException;
use frontend\models\Sessions;
use common\models\Users;
use common\models\Ads;
use common\models\Favorites;
use backend\models\Promotions;
use common\models\HistoryOperations;
use common\models\UsersCatalog;
use common\models\Category;
use backend\models\AdvertisingItems;
use common\models\Regions;

class ProfileController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if(Yii::$app->user->identity->id === null)
        {
            throw new HttpException(403, 'У вас нет разрешения на доступ к этому действию.');
        }

	        $this->enableCsrfValidation = ($action->id !== "set-img"); 
	        return parent::beforeAction($action);
        /*if($action->id == "set-img"){
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);*/
    }

    public function actionIndex()
    {
    	$session = new Sessions();
    	$identity = Yii::$app->user->identity;
        $favorites = Favorites::find()->where(['type' => 1])->all();
        $promotions = Promotions::find()->all();
        $history = HistoryOperations::find()->where(['user_id' => $identity->id])->all();
        $favId = [];
        foreach ($favorites as $value) {
            $favId [] = $value->field_id;
        }

        $favoriteAds = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->where(['in', 'ads.id', $favId])
            ->all();

        $myAds = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->where(['ads.user_id' => $identity->id])
            ->all();

        return $this->render('index',[
        	'identity' => $identity,
            'myAds' => $myAds,
            'favorites' => $favorites,
            'favoriteAds' => $favoriteAds,
            'promotions' => $promotions,
            'history' => $history,
        	'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionCatalog()
    {
        $session = new Sessions();
        $adv = $session->getCatalogAdv();
        $regions = $session->getRegionsList();
        $identity = Yii::$app->user->identity;
        $categories = Category::getAllCategoryList();
        $usersCatalog = UsersCatalog::find()->joinWith(['ads'])->where(['users_catalog.user_id' => $identity->id])->all();

        $reklama = AdvertisingItems::find()
            ->where(['advertising_id' => $adv->id])
            ->orderBy(['rand()' => SORT_DESC])
            ->one();
        if($reklama != null) {
            $reklama->view_count = $reklama->view_count + 1;
            $reklama->save();
        }

        return $this->render('catalog',[
            'identity' => $identity,
            'session' => $session,
            'regions' => $regions,
            'categories' => $categories,
            'reklama' => $reklama,
            'usersCatalog' => $usersCatalog,
            'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionEdit()
    {
        $session = new Sessions();
        $identity = Yii::$app->user->identity;
        $favorites = Favorites::find()->where(['type' => 1])->all();
        $promotions = Promotions::find()->all();
        $history = HistoryOperations::find()->where(['user_id' => $identity->id])->all();
        $favId = [];
        foreach ($favorites as $value) {
            $favId [] = $value->field_id;
        }

        $favoriteAds = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->where(['in', 'ads.id', $favId])
            ->all();

        $myAds = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->where(['ads.user_id' => $identity->id])
            ->all();

        return $this->render('_form',[
            'identity' => $identity,
            'myAds' => $myAds,
            'favorites' => $favorites,
            'favoriteAds' => $favoriteAds,
            'promotions' => $promotions,
            'history' => $history,
            'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionChat()
    {
        $session = new Sessions();
        $identity = Yii::$app->user->identity;
        $favorites = Favorites::find()->where(['type' => 1])->all();
        $promotions = Promotions::find()->all();
        $history = HistoryOperations::find()->where(['user_id' => $identity->id])->all();
        $favId = [];
        foreach ($favorites as $value) {
            $favId [] = $value->field_id;
        }

        $favoriteAds = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->where(['in', 'ads.id', $favId])
            ->all();

        $myAds = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->where(['ads.user_id' => $identity->id])
            ->all();

        return $this->render('chat',[
            'identity' => $identity,
            'myAds' => $myAds,
            'favorites' => $favorites,
            'favoriteAds' => $favoriteAds,
            'promotions' => $promotions,
            'history' => $history,
            'nowLanguage' => Yii::$app->language,
        ]);
    }


    public function actionSetImg()
    {
         if(isset($_POST) == true){
            //generate unique file name
            $fileName = time().'_'.basename($_FILES["file"]["name"]);
            $id = $_POST['id'];
            
            //file upload path
           	$path = Yii::getAlias('@backend');
            $targetDir = $path. "/web/uploads/avatars/";
            $targetFilePath = $targetDir . $fileName;
            
            //allow certain file formats
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $allowTypes = array('jpg','png','jpeg','gif');
            
            if(in_array($fileType, $allowTypes)){
                //upload file to server
                if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                    //insert file data into the database if needed
                    $user = Users::findOne($id);
                    $user->avatar = $fileName;
                    $user->save();
                    $response['status'] = 'ok';
                }else{
                    $response['status'] = 'err';
                }
            }else{
                $response['status'] = $fileName;
            }
            
            //render response data in JSON format
            return json_encode($response);
        }
    }

}
