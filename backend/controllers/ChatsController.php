<?php

namespace backend\controllers;

use Yii;
use common\models\Chats;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use common\models\ChatMessage;
use common\models\ChatUsers;


/**
 * ChatsController implements the CRUD actions for Chats model.
 */
class ChatsController extends Controller
{
    /**
     * @inheritdoc
     */
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
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Chats models.
     * @return mixed
     */
    public function actionIndex($chat_id = null)
    {
        $chat_live = ChatMessage::find()
            ->joinWith('user')
            ->where(['chat_id' => $chat_id])
            ->orderBy(['id' => SORT_ASC])
            ->all();
   
        if( $chat_id != null ){
            $chatMessages = ChatMessage::find()
                ->where(['!=', 'user_id', Yii::$app->user->identity->id])
                ->andWhere(['chat_id' => $chat_id, 'is_read' => 0])
                ->all();
            foreach ($chatMessages as $value) {
               $value->is_read = 1;
               $value->save();
            }
        }

        return $this->render('index', [
            'chat_live' => $chat_live,
            'chat_id' => $chat_id,
        ]);
    }

    public function actionSendMessage($uname, $msg)
    {
        if($msg != null) {
            $chat = new ChatMessage();
            $chat->chat_id = $uname;
            $chat->user_id = Yii::$app->user->identity->id;
            $chat->message = $msg;
            $chat->save();
        }
    }

    public function actionSendMultiple()
    {
        $request = Yii::$app->request;
        $model = new ChatMessage(); 

        if($request->isAjax){
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->validate()){
                foreach ($request->post()['chat-users'] as $value) {
                      $model_item = new ChatMessage();
                      $chat = Chats::find()->where(['name'=>'chat_'.$value])->one();
                      $model_item->chat_id = $chat->id;
                      $model_item->user_id = Yii::$app->user->identity->id;
                      $model_item->message = $model->message;
                      $model_item->save();
                }
                return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];         
            }else{           
                return [
                    'title'=> "Создать",
                    'content'=>$this->renderAjax('_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Отправить',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }
    }

    /**
     * Finds the Chats model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chats the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chats::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
