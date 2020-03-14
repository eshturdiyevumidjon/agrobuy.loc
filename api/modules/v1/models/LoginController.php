<?php
 
namespace api\modules\v1\controllers;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use api\modules\v1\models\Users;
use api\modules\v1\models\User;
use api\modules\v1\models\LoginForm;
use api\modules\v1\models\ForRegister;
use api\modules\v1\models\RegisterForm;
use api\modules\v1\models\ResetPassword;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile; 

class LoginController extends \yii\rest\ActiveController
{            
    public $modelClass = 'api\modules\v1\models\Users';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
            ],
        ];
                 
        $behaviors['authenticator']['except'] = [
            'options',
            'login',
            'registry',
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

    // -----------------------------Avtorizatsiya --------------------------
    public function actionLogin()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['username'])) return ['username' => "You must enter username"];
        if(!isset($body['password'])) return ['password' => "You must enter password"];

        $user_login = new LoginForm();

        $user_login->username = $body['username'];
        $user_login->password = $body['password'];

        if($user_login->validate())
        {
            $user = Users::find()->where(['login' => $body['username']])->one();
            $user->access_token = Yii::$app->getSecurity()->generateRandomString();
            $user->expiret_at = time() + $user::EXPIRE_TIME;
            $user->save(false);
            return $user->getUsersMinValues();
        }
        else{
            throw new HttpException(422, json_encode($user_login->errors, JSON_UNESCAPED_UNICODE ));
        }
    }

    //  Register 1-qadam uchun
    public function actionRegistration()
    {
        $model = new RegisterForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        $response = \Yii::$app->getResponse();
        
        if($model->validate() && $model->register()){
            $responseData = ['status' => true];
            return $responseData;
        }else{
            throw new HttpException(422, json_encode($model->errors, JSON_UNESCAPED_UNICODE ));
        }

    }

    // Register 2-qadam
    public function actionRegConfirmation()
    {   
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['code'])) return ['code' => "You must enter code"];
        $model =  ForRegister::find()->where(['code'=>$body['code']])->one();
        if( $model == null ) return ['code' => "Код введен не верно"];
        if($model != null){
            $user = new Users();
            $user->login = $model->login;
            $user->password = $model->password;
            $user->phone = $model->phone;
            $user->type = 3;
            $user->save();

            $model->delete();

            return $user->getUsersMinValues();
        }else{
            throw new HttpException(422, json_encode($model->errors, JSON_UNESCAPED_UNICODE ));
        }
    }

    public function actionSendCode()
    {
        $model = new ResetPassword();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->step = 1;
        if($model->validate()){
            return $model->getValidatePhone();
        }
        else { 
            throw new HttpException(422, json_encode($model->errors, JSON_UNESCAPED_UNICODE ));
        }
    }

     public function actionResetPassword()
    {
        $model = new ResetPassword();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->step = 2;
        if($model->validate()){
            return $model->ResetPassword();
        }
        else { 
            throw new HttpException(422, json_encode($model->errors, JSON_UNESCAPED_UNICODE ));
        }
    }

}