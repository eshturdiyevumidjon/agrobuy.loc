<?php

namespace frontend\controllers;

use Yii;
use yii\web\HttpException;
use frontend\models\Sessions;
use yii\web\NotFoundHttpException;
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
use backend\models\UsersReyting;
use common\models\Complaints;
use yii\db\Expression;
use common\models\User;
use yii\filters\VerbFilter;
use backend\models\UsersBall;


class ProfileController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['user', 'catalog'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /*public function beforeAction($action)
    {
        if(Yii::$app->user->identity->id === null)
        {
            throw new HttpException(403, 'У вас нет разрешения на доступ к этому действию.');
        }

	        $this->enableCsrfValidation = ($action->id !== "set-img"); 
	        return parent::beforeAction($action);
        //if($action->id == "set-img"){
        //}
        //$this->enableCsrfValidation = false;
        //return parent::beforeAction($action);
    }*/

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

    public function actionCatalog($user_id = null)
    {
        if($user_id != null) {
            $identity = User::findOne($user_id);
            if($identity == null) throw new NotFoundHttpException('The requested page does not exist.');
        }
        else {
            $identity = Yii::$app->user->identity;
            if($identity == null) throw new NotFoundHttpException('The requested page does not exist.');
        }

        $request = Yii::$app->request;
        $session = new Sessions();
        $get = null;
        $dataProvider = null;
        $searchModel = new AdsSearch();
        $adv = $session->getCatalogAdv();
        $regions = $session->getRegionsList();
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
            'path' => Yii::$app->user->identity == null ? '/profile/user?id=' . $identity->id : '/profile',
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

        $usersReyting = UsersReyting::find()
            ->select([new Expression('SUM(users_reyting.ball) as ball'), 'reyting_id',])
            ->joinWith(['reyting'])
            ->where(['user_id' => $model->id])
            ->groupBy('reyting_id')
            ->all();

        return $this->render('_form',[
            'usersReyting' => $usersReyting,
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

    public function actionComplaint($id)
    {
        $request = Yii::$app->request;
        $identity = Yii::$app->user->identity;
        $model = new Complaints();
        $model->user_from = $identity->id;
        $model->ads_id = $id;
        $model->user_id = $model->ads->user_id;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load($request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['/ads/view?id=' . $id]);
        }
        else {
            return $this->renderAjax('forms/_complaint_form', [
                'model' => $model,
            ]);
        }
    }

    public function actionUser($id)
    {
        $session = new Sessions();
        $user = User::findOne($id);
        if(Yii::$app->user->identity != null) $identity = Yii::$app->user->identity;
        else $identity = null;
        $adsPagination = Yii::$app->params['adsPagination'];
        $searchModel = new AdsSearch();
        $favorites = Favorites::find()->where(['type' => 1])->all();

        $myAdsdataProvider = $searchModel->filtrMyAds($user);
        $myAdsdataProvider->pagination = ['pageSize' => $adsPagination,];

        return $this->render('user',[
            'identity' => $user,
            //'user' => $user,
            'favorites' => $favorites,
            'myAdsdataProvider' => $myAdsdataProvider,
            'nowLanguage' => Yii::$app->language,
        ]);
    }


    public function actionStar($id)
    {
        $request = Yii::$app->request;
        $identity = Yii::$app->user->identity;
        $model = UsersBall::find()->where(['user_from' => $identity->id, 'user_to' => $id])->one();
        if($model == null) {
            $model = new UsersBall();
            $model->user_from = $identity->id;
            $model->user_to = $id;
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load($request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['/profile/user?id=' . $id]);
        }
        else {
            return $this->renderAjax('forms/_star', [
                'model' => $model,
                'nowLanguage' => Yii::$app->language,
            ]);
        }
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
