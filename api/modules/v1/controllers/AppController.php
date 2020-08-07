<?php
 
namespace api\modules\v1\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use api\modules\v1\models\Users;
use api\modules\v1\models\User;
use api\modules\v1\models\Ads;
use api\modules\v1\models\Lang;
use api\modules\v1\models\Promotions;
use api\modules\v1\models\HistoryOperations;
use api\modules\v1\models\Favorites;
use api\modules\v1\models\PriceList;
use api\modules\v1\models\Complaints;
use api\modules\v1\models\UsersCatalog;




class AppController extends \yii\rest\ActiveController
{ 	        
    public $modelClass = 'api\modules\v1\models\Users';
    public $enableCsrfValidation = false;

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }

	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
           'class'       => CompositeAuth::className(),
            'authMethods' => [
                \yii\filters\auth\HttpBearerAuth::className(),
            ],
         ];
        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
		// add CORS filter
		$behaviors['corsFilter'] = [
			'class' => \yii\filters\Cors::className(),
			'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
		];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = [
            'options',
            'restore-password',
            'change-password',
            'privacy',
            'profile',
            'profile-catalog',
            'catalog',
        ];

        $behaviors[ 'access'] = [
            'class' =>  AccessControl::className(),
            //'only' => ['login', 'cabinet'],
            'rules' => [
                [
                    'allow' => true,
                    'actions'=>['profile','profile-catalog','catalog'],
                    'roles' => ['?'],
                ],                
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        
		return $behaviors;
	}
    
	public function actions()
    {
		$actions = parent::actions();
		unset($actions['create']);
		unset($actions['update']);
		unset($actions['delete']);
		unset($actions['view']);
		unset($actions['index']);
		return $actions;
	}

	 //-----------------------log out------------------------------
    public function actionLogout()
    {
        $user = User::findOne(Yii::$app->user->identity->id);
        // return $user;
        if (!empty($user)) {
            $user->access_token = null;
            $user->save(false);
            Yii::$app->user->logout(false);
            $arr = ['status' => true,];
            return $arr;
        }
        throw new HttpException(422, "The reuestsed page does not exist.");
    }

    	 //-----------------------change avatar------------------------------
    public function actionAvatar()
    {
        $user = Users::findOne(\Yii::$app->user->identity->id);
        $user->image = UploadedFile::getInstanceByName('user_image');
        // $siteName = Yii::$app->params['siteName'];
        if (empty($user->image)) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(204);
            return "Must upload at least 1 file in upfile form-data POST";
        }
        $user->load(Yii::$app->getRequest()->getBodyParams(), '');
        $path = Yii::getAlias('@app');
       	return $user->upload($path);
    }

    //  ------------------------- Userning umumiy ma'lumotlar -------------------
    public function actionInformation()
    {
        $response = \Yii::$app->getResponse();
        $response->setStatusCode(202);
        return Yii::$app->user->identity->getUsersAllValues();
    }

    //------------------------- users ma'lumotlarni o'zgartirish---------------------------------
    public function actionUpdatePersonal()
    {   
        $user_id = Yii::$app->user->identity->id;
        $model = Users::find()->where(['id'=>$user_id])->one();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->validate()) {
            $model->save();
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            return $model->getUsersPersonalValues();
        }
        else {
            throw new HttpException(422, json_encode($model->errors, JSON_UNESCAPED_UNICODE));
        }
    }

    // -------------------------------update qilih uchun 2-qadam----------------------------
    public function actionUpdateStatus()
    {   
        $user_id = Yii::$app->user->identity->id;
        $model = Users::find()->where(['id'=>$user_id])->one();
        $model->step_validate = 2;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->validate()) {
            $model->save();
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            return $model->getUsersStatusValues();
        }
        else {
            throw new HttpException(422, json_encode($model->errors, JSON_UNESCAPED_UNICODE));
        }
    }

    // -------------------------update qilih uchun 3-qadam---------------------------------
    public function actionUpdatePassport()
    {   
        $user_id = Yii::$app->user->identity->id;
        $model = Users::find()->where(['id'=>$user_id])->one();
        $model->step_validate = 3;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->validate()) {
        	$model->passport_date = date('Y-m-d', strtotime($model->passport_date));
        	$model->passport_issue = date('Y-m-d', strtotime($model->passport_issue));
            $model->save();
            $model->passport_image = UploadedFile::getInstanceByName('files');
            // return $model->passport_image;
            if($model->passport_image != null){
    	        $path = Yii::getAlias('@app');
    	       	$model->uploadPassport($path);
            }

            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            return $model->getUsersPassportValues();
        }
        else {
            throw new HttpException(422, json_encode($model->errors, JSON_UNESCAPED_UNICODE));
        }
    }

    // ------------------------update qilih uchun 3-qadam-------------------------------------
    public function actionUpdateYurPersonal()
    {   
        $user_id = Yii::$app->user->identity->id;
        $model = Users::find()->where(['id' => $user_id])->one();
        $model->step_validate = 4;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->validate()) {
            $model->save();
            $model->company_image = UploadedFile::getInstanceByName('files');
            // return $model->passport_image;
            if($model->company_image != null){
                $path = Yii::getAlias('@app');
                $model->uploadPassport($path);
            }
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            return $model->getUsersYurPersonalValues();
        }
        else {
            throw new HttpException(422, json_encode($model->errors, JSON_UNESCAPED_UNICODE));
        }
    }

    // ------------------- users reyting. ma'lumotlarni o'zgartirish oynasidagi -------------------
    public function actionUsersReyting()
    {   
        return Yii::$app->user->identity->UsersReyting();
    }

    // --------------------------------------user profil--------------------------------
    public function actionProfile()
    {   $body = Yii::$app->getRequest()->getBodyParams();
        $id = (int)$body['id'];
        $array = explode(' ',\Yii::$app->getRequest()->getHeaders()['Authorization']);
        if($id == null and isset($array[1])) $id = $this->AccessUser($array[1]);
        $model = Users::find()->where(['id'=>$id])->one();
        if($model != null){
            return $model->getUserProfile();
        } else {
            throw new HttpException(422, json_encode("такого пользователя не существует", JSON_UNESCAPED_UNICODE));
        }
    }

    // ------------------------------userga tegishli cataloglar--------------------------------
    public function  actionProfileCatalog($id = null ,$page = 0)
    {   

        $body = Yii::$app->getRequest()->getBodyParams();
        $id = (int)$body['id'];
        $array = explode(' ',\Yii::$app->getRequest()->getHeaders()['Authorization']);
        $step = 2;
        $lang = $this->findLang($body['lang']);
        Yii::$app->language = $lang;

        if($id == null and isset($array[1])) { 
            $user = $this->AccessUser($array[1]);
            $id = $user;
        }

        if($id != null) {
            $query = Ads::find()->where(['user_id'=>$id])
                ->joinWith(['category', 'user', 'currency'])
                ->andFilterWhere(['ads.status' => 1]);
            if($user == $id) {
                $result = [
                    'catalog_count' => count(Ads::getSearchAds($page, $query, $lang, $body, $step)),
                    'catalog_url'=>Ads::Catalog_Url($id),
                    'promotions' => Promotions::getPromotions(),
                    'history_operation' => HistoryOperations::getHistory($user),
                    'catalog' => Ads::getSearchAds($page, $query, $lang, $body, $step),
                ];
            } else {
                $result = [
                    'catalog_count' => count(Ads::getSearchAds($page, $query, $lang, $body, $step)),
                    'catalog_url'=>Ads::Catalog_Url($id),
                    'catalog' => Ads::getSearchAds($page, $query, $lang, $body, $step),
                ]; 
            }
            return $result;
        }
        else {
            throw new HttpException(422, json_encode("такого пользователя не существует", JSON_UNESCAPED_UNICODE));
        }
    }
    //  ----------------------------users cataloglari-------------------------------------
    public function actionCatalog()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $array = explode(' ',\Yii::$app->getRequest()->getHeaders()['Authorization']);
        $step = 2;
        $lang = $this->findLang($body['lang']);
        Yii::$app->language = $lang;
        $ads = [];

        if($body['id'] == null and isset($array[1])) { 
            $user = $this->AccessUser($array[1]);
            $id = $user;
        }
        else $id = $body['id'];
        $model = User::findOne($id);

        if($id != null && $model != null) {
        $user_catalog = UsersCatalog::find()->where(['user_id'=>$id])->select('ads_id')->asArray()->all();
        foreach ($user_catalog as  $value) {
        	$ads [] = $value['ads_id'];
        }
            $query = Ads::find()->where([ 'ads.id'=> $ads])
                ->joinWith(['category', 'user', 'currency'])
                ->andFilterWhere(['ads.status' => 1]);
            $result = [
                'users' => $model->getUsersCatalog(),
                'catalog' => Ads::getSearchAds($body['page'], $query, $lang, $body, $step),
            ]; 
            return $result;
        }
        else {
            throw new HttpException(422, json_encode("такого пользователя не существует", JSON_UNESCAPED_UNICODE));
        }

    }

    // ----------------------  Users   History   Operation -----------------------------------------
    public function actionUsersHistoryOperations()
    {
        return HistoryOperations::getHistory(Yii::$app->user->identity->id);
    }

    // -----------------------------Kerakli tilni topish-----------------------------------------
    protected function findLang($url)
    {   
        $model = Lang::find()->where(['url' => $url])->one();

        if ($model != null) {
            return $model->url;
        } else {
            return "kr";
        }
    }

    // ----------------- users uchun ads ni favorite yoki un favorite qilish -------------------------------
    public function actionCheckFavorites($id = null)
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $id = $body['id'];
        $model = Ads::findOne($id);
        if($model != null)
        {   
            Favorites::CheckFavorites($id);
            return ['status'=>true];
        }
        else {
            throw new HttpException(422, json_encode("такого каталог не существует", JSON_UNESCAPED_UNICODE));
        }
    }

    // --------------------------- paymeee to'lov summalari ---------------------------------
    public function actionPayment()
    {
        return [
            'type' => 'payme',
            'price' => PriceList::getPriceList(),
        ];
    }

    //  --------------------------------  promotioins ---------------------------------------
    public function actionPromotions()
    {
        return Promotions::getPromotions();
    }

    // ---------------------- Complain ---------------------------------
    public function actionComplain()
    {	
    	$body = Yii::$app->getRequest()->getBodyParams();
    	$model = new Complaints();
    	$model->user_id = Yii::$app->user->identity->id;
    	$model->text = $body['text'];
    	$model->user_from = $body['from'];
    	$model->save();
    	$arr = ['status' => true,];
        return $arr;
    }

    public function actionCreateAds()
    {	
    	$model = new Ads();
    	$model->load(Yii::$app->getRequest()->getBodyParams(), '');
    	$body = Yii::$app->getRequest()->getBodyParams();
    	if($model->validate()){
	    	$model->user_id = Yii::$app->user->identity->id;
    		$model->save();
    		if($body['the_catalog']){
    			$model->setCheckCatalog();
    		}

	    	$model->imageFiles = UploadedFile::getInstanceByName('image');
            // return $model->passport_image;
            if($model->imageFiles != null){
    	        $path = Yii::getAlias('@app');
    	       	$model->upload($path);
    	       	$model = Ads::findOne($model->id);
            	return $model->getAds(Yii::$app->language);
    		}
    	}
	    	
    }


    //  -------------------------user login qilganmi yoki yo'q-------------------------------
    public function AccessUser($token)
    {
        $nowUser = User::findIdentityByAccessToken($token);
        if($nowUser != null) return $nowUser['id'];
        else return null;
    }


}