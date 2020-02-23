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
use yii\web\UploadedFile;
use \yii\web\Response;
use common\models\Orders;

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

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $identity = Yii::$app->user->identity;
        $model = $this->findModel($identity->id);

        if($request->post()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->image = UploadedFile::getInstanceByName('ad1');
            $model->uploadFromSite();
            return $this->redirect(['/profile']);
        }

        $this->getAccess();
    	$session = new Sessions();
    	$identity = Yii::$app->user->identity;
        $adsPagination = Yii::$app->params['adsPagination'];
        $promotions = Promotions::find()->all();
        $history = HistoryOperations::find()->where(['user_id' => $identity->id])->all();
        $favorites = Favorites::find()->select('field_id')->where(['type' => 1, 'user_id' => $identity->id])->column();

        $searchModel = new AdsSearch();
        $favoriteAdsdataProvider = $searchModel->filtrMyFavorites($favorites);
        $favoriteAdsdataProvider->pagination = ['pageSize' => $adsPagination,];

        $myAdsdataProvider = $searchModel->filtrMyAds($identity);
        $myAdsdataProvider->pagination = ['pageSize' => $adsPagination,];

        return $this->render('index',[
        	'identity' => $identity,
            'myAdsdataProvider' => $myAdsdataProvider,
            'favoriteAdsdataProvider' => $favoriteAdsdataProvider,
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
            $this->getAccess();
        }

        $request = Yii::$app->request;
        $session = new Sessions();
        $get = $request->get();
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
        if($get) {
            if(isset($get['category'])) $cat = $get['category'];
            if(isset($get['region'])) $reg = $get['region'];
        }
        
        $dataProvider = $searchModel->usersCatalogAds($usersCatalog, $get);
        $dataProvider->pagination = ['pageSize' => $adsPagination,];

        $reklama = AdvertisingItems::find()
            ->joinWith('advertising')
            ->where(['advertising_id' => $adv->id])
            ->orderBy(['rand()' => SORT_DESC])
            ->all();
        foreach ($reklama as $value) {
            $value->view_count = $value->view_count + 1;
            $value->save();
        }

        return $this->render('catalog',[
            'identity' => $identity,
            'session' => $session,
            'regions' => $regions,
            'cat' => $cat,
            'reg' => $reg,
            'get' => $get,
            'user_id' => $user_id,
            'path' => Yii::$app->user->identity == null ? '/profile/user?id=' . $identity->id : '/profile',
            'categories' => $categories,
            'reklama' => $reklama,
            'dataProvider' => $dataProvider,
            'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionEdit()
    {
        $this->getAccess();
        $request = Yii::$app->request;
        $model = Users::findOne(Yii::$app->user->identity->id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load($request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['/profile']);
        }

        $usersReyting = UsersReyting::find()
            ->select([new Expression('SUM(users_reyting.ball) as ball'), 'reyting_id',])
            ->joinWith(['reyting'])
            ->where(['user_id' => $model->id])
            ->groupBy('reyting_id')
            ->all();

        return $this->render('_form',[
            'usersReyting' => $usersReyting,
            'model' => $model,
            'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionChat()
    {
        $this->getAccess();
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
        $this->getAccess();
        $request = Yii::$app->request;
        $identity = Yii::$app->user->identity;
        $pliceList = PriceList::find()->orderBy(['number' => SORT_ASC])->all();

        if ($request->post()) {
            if($request->post()['puy'] == 'payme') {
                $amount = $request->post()['summ'] * 100;
                $model = new Orders();
                $model->user_id = $identity->id;
                $model->amount = $amount;
                $model->save();

                return $this->redirect('https://checkout.paycom.uz/'.base64_encode('m=5e4cdd47af9572847bcadc31;ac.order_id='.$model->id.';a='.$amount));
            }
        }

        return $this->render('replenish',[
            'identity' => $identity,
            'pliceList' => $pliceList,
            'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionComplaint($id = null, $user_id = null)
    {
        $this->getAccess();
        $request = Yii::$app->request;
        $identity = Yii::$app->user->identity;
        $model = new Complaints();
        $model->user_from = $identity->id;
        if($id != null) {
            $model->ads_id = $id;
            $model->user_id = $model->ads->user_id;
        }
        if($user_id != null) {
            $model->ads_id = null;
            $model->user_id = $user_id;
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load($request->post()) && $model->validate() && $model->save()) {
            if($id != null) return $this->redirect(['/ads/view?id=' . $id]);
            if($user_id != null) return $this->redirect(['/chat']);
            return $this->redirect(['/profile']);
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
        $user = $this->findUser($id);
        $adsPagination = Yii::$app->params['adsPagination'];

        $searchModel = new AdsSearch();
        $myAdsdataProvider = $searchModel->filtrMyAds($user);
        $myAdsdataProvider->pagination = ['pageSize' => $adsPagination,];
        $favorites = Favorites::find()->where(['type' => 1, 'user_id' => $id])->all();

        return $this->render('user',[
            'identity' => $user,
            'favorites' => $favorites,
            'myAdsdataProvider' => $myAdsdataProvider,
            'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionStar($id)
    {
        $this->getAccess();
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

    /*public function actionAvatar()
    {
        $request = Yii::$app->request;
        $identity = Yii::$app->user->identity;
        $model = $this->findModel($identity->id);

        if($model->load($request->post()) && $model->save()) {
        echo "<pre>";
        print_r($request->post());
        echo "</pre>";
        die;
            $model->image = UploadedFile::getInstance($model, 'image');
            $model->upload();

            return ['message'=>'success'];    
        }
    }*/

    protected function getAccess()
    {
        $identity = Yii::$app->user->identity;
        if($identity != null && $identity->access == 2) {
            throw new HttpException(403, $identity->access_comment);
        }
    }

    protected function findUser($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
