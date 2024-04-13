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
use backend\models\AboutCompany;

class ProfileController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if( $action->id == 'index' || $action->id == 'edit' || $action->id == 'chat' || 
            $action->id == 'edit' ||  $action->id == 'replenish' || $action->id == 'buy-promotion' ||
            $action->id == 'complaint' || $action->id == 'star') {
            if (Yii::$app->user->isGuest) { 
                throw new HttpException(403,'У вас нет разрешения на доступ к этому действию.');
            }
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
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

        $favoriteAds = null;

        $this->getAccess();
    	$session = new Sessions();
    	$identity = Yii::$app->user->identity;
        $adsPagination = Yii::$app->params['adsPagination'];
        $promotions = Promotions::find()->all();
        $history = HistoryOperations::find()->where(['user_id' => $identity->id])->orderBy(['id' => SORT_DESC])->all();
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

    public function actionCatalog($login = null)
    {
        if($login != null) {
            $identity = User::find()->where(['login' => $login])->one();;
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
        $districts = $session->getAreaList();
        $categories = Category::getAllCategoryList();
        $adsPagination = Yii::$app->params['adsPagination'];
        $usersCatalog = UsersCatalog::find()
            ->joinWith(['ads'])
            ->where(['users_catalog.user_id' => $identity->id])
            ->all();

        $cat = null; $dist = null;
        if($get) {
            if(isset($get['category'])) $cat = $get['category'];
            if(isset($get['district'])) $dist = $get['district'];
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
            'districts' => $districts,
            'cat' => $cat,
            'dist' => $dist,
            'get' => $get,
            'user_id' => $identity->id,
            'path' => '/profile/user?id=' . $identity->id, //Yii::$app->user->identity == null ? '/profile/user?id=' . $identity->id : '/profile',
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
            $model->passport_image = UploadedFile::getInstances($model, 'passport_image');
            // if ($model->uploadsPassport()) { }
            $model->UploadPassportImage($_POST);
            $model->UploadCompanyImage($_POST);

            // $model->company_image = UploadedFile::getInstances($model, 'company_image');
            // if ($model->uploadsCompanyImages()) { }

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
            'post' => $_POST,
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

    public function actionBuyPromotion($id)
    {
        $request = Yii::$app->request;
        $promotion = Promotions::findOne($id);
        if($promotion->top) {
            $usersAds = Ads::find()
                ->where(['user_id' => Yii::$app->user->identity->id])
                ->andWhere(['top' => 0, 'status' => 1])
                ->all();
        }
        if($promotion->premium) {
            $usersAds = Ads::find()
                ->where(['user_id' => Yii::$app->user->identity->id])
                ->andWhere(['premium' => 0, 'status' => 1])
                ->all();
        }

        if($request->post()) {
            $model = Ads::findOne($request->post()['ads']);
            if($model != null) {
                if($promotion->premium == 1) {
                    $model->premium = 1;
                    $model->premium_date = date('Y-m-d', strtotime(date('Y-m-d'). ' + ' . $promotion->days . ' days') );
                }
                if($promotion->top == 1) {
                    $model->top = 1;
                    $model->top_date = date('Y-m-d', strtotime(date('Y-m-d'). ' + ' . $promotion->days . ' days') );
                }
                $user = Users::findOne(Yii::$app->user->identity->id);
                $user->balance = $user->balance - $promotion->price;
                $user->save(false);
                $model->save();

                $history = new HistoryOperations();
                $history->type = 2;
                $history->field_id = "" . $promotion->id;
                $history->summa = $promotion->price;
                $history->save();                
            }

            return $this->redirect(['/profile']);
        }
        else {
            $aboutCompany = AboutCompany::findOne(1);
            $premiumCount = Ads::find()->where(['premium' => 1])->count();
            $topCount = Ads::find()->where(['top' => 1])->count();
            $status = 1;
            $session = new Sessions();
            if($premiumCount >= $aboutCompany->premium_ads_count) $status = 2;
            if($topCount >= $aboutCompany->top_ads_count) $status = 2;

            return $this->renderAjax('forms/_promotion_form', [
                'promotion' => $promotion,
                'status' => $status,
                'session' => $session,
                'usersAds' => $usersAds,
                'nowLanguage' => Yii::$app->language,
            ]);
        }
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

    public function actionRemovePassportFile($id, $path)
    {
        $model = $this->findModel($id);
        $array = explode(',', $model->passport_file);
        $result = "";
        foreach ($array as $value) {
            if($path != $value) {
                if($result == "") $result = $value;
                else $result .= ',' . $value;
            } else {
                if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/users/' . $path))
                {
                    unlink($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/users/' . $path);
                }
            }
        }
        $model->passport_file = $result;
        $model->save();
        return 1;
    }

    public function actionRemoveCompanyFile($id, $path)
    {
        $model = $this->findModel($id);
        $array = explode(',', $model->company_files);
        $result = "";
        foreach ($array as $value) {
            if($path != $value) {
                if($result == "") $result = $value;
                else $result .= ',' . $value;
            } else {
                if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/users/' . $path))
                {
                    unlink($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/users/' . $path);
                }
            }
        }
        $model->company_files = $result;
        $model->save();
        return 1;
    }

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

    
    // rasmlarni yuklash uchun
    public function actionSaveImg()
    {
        $images = [];
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/ads_trash/';

        for ($i = 0; $i < count($_FILES['file']['name']); $i++) {

        $ext = "";
        $ext = substr(strrchr($_FILES['file']['name'][$i], "."), 1); 

        $fPath = $_POST['names'][$i];
            if($ext != ""){
               $images []= $fPath;
               $result = move_uploaded_file($_FILES['file']['tmp_name'][$i], $uploadDir . $fPath);
            }
        }
    }

    // yuklangan passport fileni xotiradan o'chirish uchun
    public function actionDeletePassportImage($value,$id)
    {
        if($id)
        {
            $model = $this->findModel($id);
            $model->passport_file = Users::unlinkPassportFile($value,$model->passport_file);
            $model->save(false);
        }else{
            Users::unlinkPassportFile($value);
        }
    }

    // yuklangan company fileni xotiradan o'chirish uchun
    public function actionDeleteCompanyImage($value,$id)
    {
        if($id)
        {
            $model = $this->findModel($id);
            $model->company_files = Users::unlinkCompanyFile($value,$model->company_files);
            $model->save(false);
        }else{
            Users::unlinkCompanyFile($value);
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
