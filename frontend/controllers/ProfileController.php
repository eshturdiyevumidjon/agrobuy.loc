<?php

namespace frontend\controllers;

use Yii;
use yii\web\HttpException;
use frontend\models\Sessions;
use common\models\Users;
use common\models\Ads;
use common\models\AdsSearch;
use common\models\Favorites;
use backend\models\Promotions;
use common\models\HistoryOperations;
use common\models\UsersCatalog;
use common\models\Category;
use backend\models\AdvertisingItems;
use common\models\Regions;
use backend\models\PriceList;
use yii\widgets\ActiveForm;

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
        $adsPagination = Yii::$app->params['adsPagination'];
        $promotions = Promotions::find()->all();
        $history = HistoryOperations::find()->where(['user_id' => $identity->id])->all();
        $favId = [];
        foreach ($favorites as $value) {
            $favId [] = $value->field_id;
        }

        $searchModel = new AdsSearch();
        /*$favoriteAds = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->where(['in', 'ads.id', $favId])
            ->andWhere(['ads.status' => 1])
            ->all();*/

        $favoriteAdsdataProvider = $searchModel->filtrMyFavorites($favId);
        $favoriteAdsdataProvider->pagination = ['pageSize' => $adsPagination,];

        $myAdsdataProvider = $searchModel->filtrMyAds($identity);
        $myAdsdataProvider->pagination = ['pageSize' => $adsPagination,];

        return $this->render('index',[
        	'identity' => $identity,
            'myAdsdataProvider' => $myAdsdataProvider,
            'favoriteAdsdataProvider' => $favoriteAdsdataProvider,
            'favorites' => $favorites,
            'favoriteAds' => $favoriteAds,
            'promotions' => $promotions,
            'history' => $history,
        	'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionCatalog()
    {
        $request = Yii::$app->request;
        $session = new Sessions();
        $get = null;
        $dataProvider = null;
        $searchModel = new AdsSearch();
        $adv = $session->getCatalogAdv();
        $regions = $session->getRegionsList();
        $identity = Yii::$app->user->identity;
        $categories = Category::getAllCategoryList();
        $adsPagination = Yii::$app->params['adsPagination'];
        $usersCatalog = UsersCatalog::find()
            ->joinWith(['ads'])
            ->where(['users_catalog.user_id' => $identity->id])
            ->all();

        $cat = null; $reg = null;
        if($request->get()){
            $get = $request->get();
            if(isset($get['category'])) $cat = $get['category'];
            if(isset($get['region'])) $reg = $get['region'];
        }
        
        $dataProvider = $searchModel->usersCatalogAds($usersCatalog, $get);
        $dataProvider->pagination = ['pageSize' => $adsPagination,];

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
            'cat' => $cat,
            'reg' => $reg,
            'get' => $get,
            'categories' => $categories,
            'reklama' => $reklama,
            'dataProvider' => $dataProvider,
            'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionEdit()
    {
        $request = Yii::$app->request;
        $model = Users::findOne(Yii::$app->user->identity->id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load($request->post()) && $model->validate() && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Muvafaqqiyatli bajarildi');
            return $this->redirect(['/profile/edit']);
        }

        $session = new Sessions();
        //$identity = Yii::$app->user->identity;
        $favorites = Favorites::find()->where(['type' => 1])->all();
        $promotions = Promotions::find()->all();
        $history = HistoryOperations::find()->where(['user_id' => $model->id])->all();
        $favId = [];
        foreach ($favorites as $value) {
            $favId [] = $value->field_id;
        }

        $favoriteAds = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->where(['in', 'ads.id', $favId])
            ->andWhere(['ads.status' => 1])
            ->all();

        $myAds = Ads::find()
            ->joinWith(['category', 'user', 'currency'])
            ->where(['ads.user_id' => $identity->id])
            ->all();

        return $this->render('_form',[
            //'identity' => $identity,
            'model' => $model,
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
            ->andWhere(['ads.status' => 1])
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

    public function actionReplenish()
    {
        $request = Yii::$app->request;
        $identity = Yii::$app->user->identity;
        if ($request->post()) {
            /*shartli ravishda balans toldirish imkoniyati bor*/
            $identity->balance = $identity->balance + $request->post()['summ'];
            $identity->save();
            return $this->redirect(['/profile']);
            /**/
        }

        $pliceList = PriceList::find()->orderBy(['number' => SORT_ASC])->all();

        return $this->render('replenish',[
            'identity' => $identity,
            'myAds' => $myAds,
            'pliceList' => $pliceList,
            'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionPersonal()
    {
        $request = Yii::$app->request;
        echo "<pre>";
        print_r(Yii::$app->request->post());
        echo "</pre>";
        die;

        $model = new Users();
        $siteName = Yii::$app->params['siteName'];

        /*if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load($request->post()) && $model->validate() && $model->login()) {
            return $this->goBack();
        }
        else {
            return $this->renderAjax('login', [
                'model' => $model,
                'path' => $path,
                'nowLanguage' => Yii::$app->language,
            ]);
        }*/
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
