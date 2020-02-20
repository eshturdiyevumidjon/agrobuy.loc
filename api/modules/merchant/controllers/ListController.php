<?php

namespace api\modules\merchant\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use api\modules\merchant\models\User;
use api\modules\merchant\models\Orders;
use api\modules\merchant\models\Transactions;

/**
 * Default controller for the `api` module
 */
class ListController extends Controller
{
    public $modelClass = 'app\models\Api';

    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => [ 'api',],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }
    
    public function beforeAction($action) 
    {
        $this->enableCsrfValidation = ($action->id !== "api"); 
        return parent::beforeAction($action);
    }

    public function actionCode()
    {
        echo base64_encode('m=5d03a2dfe73861101f17c0a5;ac.order_id=1;a=100000');
    }

    public function actionIndex()
    {
        return $this->render('index', [ ]);
    }
    public function actionApi()
    {
        $request_body  = file_get_contents('php://input');
        $request = json_decode($request_body, true);
        $method = $request['method'];

        if($method == 'CheckPerformTransaction'){
            $id = $request['id'];
            $amount = $request['params']['amount'];
            $order_id = $request['params']['account']['order_id'];

            $result = Transactions::CheckPerformTransaction($id, $amount, $order_id);
            return $result;
        }

        if($method == 'CreateTransaction'){
            $id = $request['id'];
            $param_id = $request['params']['id'];
            $time = $request['params']['time'];
            $amount = $request['params']['amount'];
            $order_id = $request['params']['account']['order_id'];

            $result = Transactions::CreateTransaction($id, $param_id, $time, $amount, $order_id);
            return $result;
        }

        if($method == 'PerformTransaction'){
            $id = $request['id'];
            $param_id = $request['params']['id'];

            $result = Transactions::PerformTransaction($id, $param_id);
            return $result;
        }

        if($method == 'CheckTransaction'){
            $id = $request['id'];
            $param_id = $request['params']['id'];

            $result = Transactions::CheckTransaction($id, $param_id);
            return $result;            
        }

        if($method == 'CancelTransaction'){
            $id = $request['id'];
            $reason = $request['params']['reason'];
            $param_id = $request['params']['id'];

            $result = Transactions::CancelTransaction($id, $param_id, $reason);
            return $result;  
        }

        if($method == 'GetStatement'){
            $id = $request['id'];
            $from = $request['params']['from'];
            $to = $request['params']['to'];

            $result = Transactions::GetStatement($id, $from, $to);
            return $result;  
        }

        if($method == 'ChangePassword'){
            $password = $request['params']['password'];
            
            $result = Transactions::ChangePassword($password);
            return $result;  
        }

    }

}