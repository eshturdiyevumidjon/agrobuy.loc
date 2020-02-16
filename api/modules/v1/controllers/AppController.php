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
            'send',
            'user-info'
        ];

        $behaviors[ 'access'] = [
            'class' =>  AccessControl::className(),
            //'only' => ['login', 'cabinet'],
            'rules' => [
                [
                    'allow' => true,
                    'actions'=>['user-info', 'send'],
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


    public function actionInformation()
    {
        // $user = Users::find()->where(['id' => Yii::$app->user->identity->id])->one();
        $response = \Yii::$app->getResponse();
        $response->setStatusCode(202);
        return Yii::$app->user->identity->getUsersAllValues();
    }

    // update qilih uchun 1-qadam
    public function actionUpdatePersonal()
    {   
        $user_id = Yii::$app->user->identity->id;
        $model = Users::find()->where(['id'=>$user_id])->one();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->validate()) {
            $model->save();
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            return $model->getUsersAllValues();
        }
        else {
            throw new HttpException(422, json_encode($model->errors, JSON_UNESCAPED_UNICODE));
        }
    }

    // update qilih uchun 2-qadam
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
            return $model->getUsersAllValues();
        }
        else {
            throw new HttpException(422, json_encode($model->errors, JSON_UNESCAPED_UNICODE));
        }
    }

    // update qilih uchun 3-qadam
    public function actionUpdatePassport()
    {   
        $user_id = Yii::$app->user->identity->id;
        $model = Users::find()->where(['id'=>$user_id])->one();
        $model->step_validate = 3;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->validate()) {
            $model->save();
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            return $model->getUsersAllValues();
        }
        else {
            throw new HttpException(422, json_encode($model->errors, JSON_UNESCAPED_UNICODE));
        }
    }

    // update qilih uchun 3-qadam
    public function actionUpdateYurPersonal()
    {   
        $user_id = Yii::$app->user->identity->id;
        $model = Users::find()->where(['id'=>$user_id])->one();
        $model->step_validate = 4;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->validate()) {
            $model->save();
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            return $model->getUsersAllValues();
        }
        else {
            throw new HttpException(422, json_encode($model->errors, JSON_UNESCAPED_UNICODE));
        }
    }
 
}