<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ChatHandler;
use common\models\ChatMessage;
use yii\widgets\ActiveForm;
use common\models\ChatUsers;
use common\models\Chats;
use \yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

class ChatController extends \yii\web\Controller
{
    public function actionIndex($chat = null)
    {
    	if (Yii::$app->user->isGuest) throw new ForbiddenHttpException('You are not allowed to access this page');

    	$identity = Yii::$app->user->identity;
    	$nowChatId = null;
    	$guestUserId = null;

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
    	array_multisort(array_column($chatList, 'date_cr'), SORT_DESC, $chatList);

    	$onlineChatUser = ChatUsers::find()
    		->joinWith(['chat', 'user'])
    		->where(['chats.name' => $chat])
    		->andWhere(['!=', 'user_id', $identity->id])
    		->one();

    	/*echo "<pre>";
    	print_r($chatList);
    	echo "</pre>";
    	die;*/

    	return $this->render('index',[
        	'identity' => $identity,
        	'chat' => $chat,
        	'guestUserId' => $guestUserId,
        	'nowChatId' => $nowChatId,
        	'onlineChatUser' => $onlineChatUser,
            'messages' => $messages,
            'chatList' => $chatList,
        	'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionMessage($user_id)
    {
    	if (Yii::$app->user->isGuest) throw new ForbiddenHttpException('You are not allowed to access this page');

        $request = Yii::$app->request;
        $identity = Yii::$app->user->identity;
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
        $model->chat_id = $chat->id;
        $model->user_id = $identity->id;
        //$model->message = $chat->name;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load($request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['/chat/index?chat=chat_12_1']);
        }
        else {
            return $this->renderAjax('message', [
                'model' => $model,
                'nowLanguage' => Yii::$app->language,
            ]);
        }
    }

    public function actionSet($chat_id, $msg, $user_id)
    {
    	$model = new ChatMessage();
    	$model->chat_id = (integer)$chat_id;
    	$model->message = (string)$msg;
    	$model->user_id = (integer)$user_id;
    	if($model->save()) return true;
    	else return $model->errors;
    }

    public function actionDeleteForm($id)
    {
        $model = Chats::find()->where(['name' => $id])->one();

        return $this->renderAjax('_delete_form',[
            'model' => $model,
            'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionDelete($id)
    {
        $model = Chats::findOne($id);
        $model->delete();
        return $this->redirect(['/chat']);
    }
}
