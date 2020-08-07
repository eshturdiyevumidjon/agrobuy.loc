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
use api\modules\v1\models\Chats;
use api\modules\v1\models\ChatUsers;
use api\modules\v1\models\ChatMessage;






class ChatController extends \yii\rest\ActiveController
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
        ];

        $behaviors[ 'access'] = [
            'class' =>  AccessControl::className(),
            //'only' => ['login', 'cabinet'],
            'rules' => [
                [
                    'allow' => true,
                    'actions'=>['profile'],
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

    public function actionCreateChat()
    {   
        $model = new ChatMessage();
        
        $body = Yii::$app->getRequest()->getBodyParams();
        $identity = Yii::$app->user->identity;
        $user_id = $body['user_id'];

        $chat = Chats::find()
            ->orWhere(['name' => 'chat_' . $identity->id . '_' . $user_id, 'type' => 2])
            ->orWhere(['name' => 'chat_' . $user_id . '_' . $identity->id, 'type' => 2])
            ->one();

         if($chat == null) {
            $chat = new Chats();
            $chat->name = 'chat_' . $identity->id . '_' . $user_id;
            $chat->type = 2;
            $chat->save();

            $chatUser = new ChatUsers();
            $chatUser->chat_id = $chat->id;
            $chatUser->user_id = $user_id;
            $chatUser->save();

            $chatUser = new ChatUsers();
            $chatUser->chat_id = $chat->id;
            $chatUser->user_id = $identity->id;
            $chatUser->save();
        } 
        else {
            $chatUser = ChatUsers::find()->where(['chat_id' => $chat->id, 'user_id' => $user_id])->one();
            if($chatUser == null) {
                $chatUser = new ChatUsers();
                $chatUser->chat_id = $chat->id;
                $chatUser->user_id = $user_id;
                $chatUser->save();
            }

            $chatUser = ChatUsers::find()->where(['chat_id' => $chat->id, 'user_id' => $identity->id])->one();
            if($chatUser == null) {
                $chatUser = new ChatUsers();
                $chatUser->chat_id = $chat->id;
                $chatUser->user_id = $identity->id;
                $chatUser->save();
            }
        }

        $model = new ChatMessage();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->chat_id = $chat->id;
        $model->user_id = $identity->id;
        if($model->validate()) {
            $model->save();
            $arr = ['status' => 'success'];
            return $arr;
        }

        else {
            throw new HttpException(422, json_encode($model->errors, JSON_UNESCAPED_UNICODE));
        }
    }

    public function actionChatIndex($chat = null)
    {

    	$identity = Yii::$app->user->identity;
    	$nowChatId = null;
    	$guestUserId = null;
    	$body = Yii::$app->getRequest()->getBodyParams();
    	if($body['chat' != null]) $chat = $body['chat'];
    	
    	if($chat != null) {
    		$chatUser = ChatUsers::find()
    			->joinWith(['chat'])
    			->where(['user_id' => $identity->id, 'chats.name' => $chat])
    			->one();
    		if($chatUser == null) throw new NotFoundHttpException('The requested page does not exist.');
    		$nowChatId = Chats::find()->where(['name' => $chat])->one()->id;
    	}

    	$messages = ChatMessage::getMessagesList($chat);
    	$chatList = Chats::getUsersListChat();

    	$onlineChatUser = ChatUsers::find()
    		->joinWith(['chat', 'user'])
    		->where(['chats.name' => $chat])
    		->andWhere(['!=', 'user_id', $identity->id])
    		->one();

    	return [
        	'identity' => $identity,
        	'chat' => $chat,
        	'guestUserId' => $guestUserId,
        	'nowChatId' => $nowChatId,
        	'onlineChatUser' => $onlineChatUser,
            'messages' => $messages,
            'chatList' => $chatList,
        	'nowLanguage' => Yii::$app->language,
        ];
    }

    public function actionSendMesagge($chat_id, $msg, $user_id)
    {
    	$model = new ChatMessage();
    	$model->chat_id = (integer)$chat_id;
    	$model->message = (string)$msg;
    	$model->user_id = (integer)$user_id;
    	if($model->save()) return ['status'=> true];
    	else {
            throw new HttpException(422, json_encode($model->errors, JSON_UNESCAPED_UNICODE));
        }
    }

}