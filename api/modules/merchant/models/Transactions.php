<?php

namespace api\modules\merchant\models;

use Yii;
use api\modules\merchant\models\Orders;

/**
 * This is the model class for table "transactions".
 *
 * @property int $id
 * @property string $paycom_transaction_id
 * @property string $paycom_time
 * @property string $paycom_time_datetime
 * @property string $create_time
 * @property string $perform_time
 * @property string $cancel_time
 * @property int $amount
 * @property int $state
 * @property int $reason
 * @property string $receivers
 * @property int $order_id
 */
class Transactions extends \yii\db\ActiveRecord
{

    /** Transactions expiration time in milliseconds. 43 200 000 ms = 12 hours. */
    const TIMEOUT = 43200000;

    const STATE_CREATED                  = 1;
    const STATE_COMPLETED                = 2;
    const STATE_CANCELLED                = -1;
    const STATE_CANCELLED_AFTER_COMPLETE = -2;

    const REASON_RECEIVERS_NOT_FOUND         = 1;
    const REASON_PROCESSING_EXECUTION_FAILED = 2;
    const REASON_EXECUTION_FAILED            = 3;
    const REASON_CANCELLED_BY_TIMEOUT        = 4;
    const REASON_FUND_RETURNED               = 5;
    const REASON_UNKNOWN                     = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paycom_time_datetime', 'create_time'], 'safe'],
            [['amount', 'state', 'reason', 'order_id'], 'integer'],
            [['paycom_transaction_id', 'paycom_time', 'perform_time', 'cancel_time', 'receivers', 'param_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'paycom_transaction_id' => 'Paycom Transaction ID',
            'param_id' => 'Param ID',
            'paycom_time' => 'Paycom Time',
            'paycom_time_datetime' => 'Paycom Time Datetime',
            'create_time' => 'Create Time',
            'perform_time' => 'Perform Time',
            'cancel_time' => 'Cancel Time',
            'amount' => 'Amount',
            'state' => 'State',
            'reason' => 'Reason',
            'receivers' => 'Receivers',
            'order_id' => 'Order ID',
        ];
    }

    public static function datetime2timestamp($datetime)
    {
        if ($datetime) {
            return 1000 * strtotime($datetime);
        }

        return $datetime;
    }

    public static function timestamp2seconds($timestamp)
    {
        // is it already as seconds
        if (strlen((string)$timestamp) == 10) {
            return $timestamp;
        }

        return floor(1 * $timestamp / 1000);
    }

    public static function timestamp2datetime($timestamp)
    {
        // if as milliseconds, convert to seconds
        if (strlen((string)$timestamp) == 13) {
            $timestamp = Transactions::timestamp2seconds($timestamp);
        }

        // convert to datetime string
        return date('Y-m-d H:i:s', $timestamp);
    }

    public function CheckPerformTransaction($id, $amount, $order_id)
    {
        if($order_id == null) {
            return [
                'jsonrpc' => "2.0", 
                'error' => [
                    'code' => -32504,
                    'message' => "Недостаточно привилегий для выполнения метода."
                ] 
            ];
        }
        $order = Orders::findOne($order_id);
        if($order == null) {
            return [
                'jsonrpc' => "2.0", 
                'error' => [
                    'code' => -31050,
                    'message' => "Ошибки связанные с неверным пользовательским вводом “account“. Например: введённый логин не найден, введённый номер телефона не найден и т.д."
                ] 
            ];
        }
        if($amount < 50000 || $order->amount != $amount) {
            return [
                'jsonrpc' => "2.0", 
                'error' => [
                    'code' => -31001,
                    'message' => "Неверная сумма."
                ] 
            ];
        }
        /*if($order->state != 1){
            return [
                'jsonrpc' => "2.0", 
                'error' => [
                    'code' => -31050,
                    'message' => "2Ошибки связанные с неверным пользовательским вводом “account“. Например: введённый логин не найден, введённый номер телефона не найден и т.д."
                ] 
            ];
        }*/
        return ['result' => ['allow' => true]];
    }

    public function CreateTransaction($id, $param_id, $time, $amount, $order_id)
    {
        $transaction = Transactions::find()->where(['param_id' => $param_id])->one();
        if($transaction == null){
            $checkPerformTransaction = Transactions::CheckPerformTransaction($id, $amount, $order_id);
            if(isset($checkPerformTransaction['result']['allow'])){
                $transaction = new Transactions();
                $create_time                        = round(microtime(true) * 1000);
                $transaction->paycom_transaction_id = (string)$id;
                $transaction->param_id              = (string)$param_id;
                $transaction->paycom_time           = (string)$time;
                $transaction->paycom_time_datetime  = Transactions::timestamp2datetime($time);
                $transaction->create_time           = Transactions::timestamp2datetime($create_time);
                $transaction->state                 = Transactions::STATE_CREATED;
                $transaction->amount                = $amount;
                $transaction->order_id              = $order_id;
                $transaction->save(); // after save $transaction->id will be populated with the newly created transaction's id.

                $order = Orders::findOne($order_id);
                $order->state = 2;
                $order->save();

                return [
                    'result' => [
                        'create_time' => Transactions::datetime2timestamp($transaction->create_time),
                        'transaction' => (string)$transaction->paycom_transaction_id,
                        'state'       => $transaction->state,
                        'receivers'   => null,
                    ]
                ];
            }
            else{
                return $checkPerformTransaction;
            }
        }else{
            if($transaction->state == 1){
                /*wu yerda chala qism bor*/
                return [
                    'result' => [
                        'create_time' => Transactions::datetime2timestamp($transaction->create_time),
                        'transaction' => (string)$transaction->paycom_transaction_id,
                        'state'       => $transaction->state,
                        'receivers'   => null,
                    ]
                ];
            }else{
                return [
                    'jsonrpc' => "2.0", 
                    'error' => [
                        'code' => -31008,
                        'message' => "Невозможно выполнить операцию."
                    ] 
                ];
            }
        }
    }

    public function PerformTransaction($id, $param_id)
    {
        $transaction = Transactions::find()->where(['param_id' => $param_id])->one();
        if($transaction == null){
            return [
                'jsonrpc' => "2.0", 
                'error' => [
                    'code' => -32504,
                    'message' => "Недостаточно привилегий для выполнения метода."
                ] 
            ];
            /*return [
                'jsonrpc' => "2.0", 
                'error' => [
                    'code' => -31003,
                    'message' => "Транзакция не найдена"
                ] 
            ];*/
        }
        else{
            if($transaction->state == 1){
                /*timeoutga tekwirish kerak*/
                if(1 == 0){
                    $transaction->state = -1;
                    $transaction->reason = 4;
                    $transaction->save();
                    return [
                        'jsonrpc' => "2.0", 
                        'error' => [
                            'code' => -31008,
                            'message' => "Невозможно выполнить операцию."
                        ] 
                    ];
                }
                else{
                    $order = Orders::findOne($transaction->order_id);
                    $order->state = 3;
                    $order->save();

                    $user = User::findOne($order->user_id);
                    $user->balance = $user->balance + $order->amount/100;
                    $user->save();

                    $transaction->state = 2;
                    $transaction->perform_time = (string)round(microtime(true) * 1000);
                    $transaction->save();

                    return [
                        'result' => [
                            'perform_time' => (integer)$transaction->perform_time,
                            'transaction' => $transaction->paycom_transaction_id,
                            'state' => $transaction->state,
                        ]
                    ];
                }
            }
            else{
                if($transaction->state == 2){
                    return [
                        'result' => [
                            'perform_time' => (integer)$transaction->perform_time,
                            'transaction' => $transaction->paycom_transaction_id,
                            'state' => $transaction->state,
                        ]
                    ];
                }
                else{
                    return [
                        'jsonrpc' => "2.0", 
                        'error' => [
                            'code' => -31008,
                            'message' => "Невозможно выполнить операцию."
                        ] 
                    ];
                }
            }
        }
    }

    public function CheckTransaction($id, $param_id)
    {
        $transaction = Transactions::find()->where(['param_id' => $param_id])->one();
        if($transaction == null){
            /*return [
                'jsonrpc' => "2.0", 
                'error' => [
                    'code' => -31003,
                    'message' => "Транзакция не найдена."
                ] 
            ];*/
            return [
                'jsonrpc' => "2.0", 
                'error' => [
                    'code' => -32504,
                    'message' => "Недостаточно привилегий для выполнения метода."
                ] 
            ];

        }

        return [
            'result' => [
                'create_time' => Transactions::datetime2timestamp($transaction->create_time),
                'perform_time' => (integer)$transaction->perform_time,
                'cancel_time' => (integer)$transaction->cancel_time,
                'transaction' => $transaction->paycom_transaction_id,
                'state' => $transaction->state,
                'reason' => $transaction->reason,
            ]
        ];
    }

    public function CancelTransaction($id, $param_id, $reason)
    {
        $transaction = Transactions::find()->where(['param_id' => $param_id])->one();
        if($transaction == null){
            if($reason != null){
                return [
                    'jsonrpc' => "2.0", 
                    'error' => [
                        'code' => -31003,
                        'message' => "Транзакция не найдена."
                    ] 
                ];
            }else{
                return [
                    'jsonrpc' => "2.0", 
                    'error' => [
                        'code' => -32504,
                        'message' => "Недостаточно привилегий для выполнения метода."
                    ] 
                ];
            }
        }
        else{
            if($transaction->state == 1){
                $transaction->state = -1;
                $transaction->reason = $reason;
                $transaction->cancel_time = (string)round(microtime(true) * 1000); ///risk xatolik boliwi mumkin
                $transaction->save();

                $order = Orders::findOne($transaction->order_id);
                $order->state = 4;
                $order->save();

                $user = User::findOne($order->user_id);
                $user->balance = $user->balance - $order->amount/100;
                $user->save();

                return [
                    'result' => [
                        'transaction' => $transaction->paycom_transaction_id,
                        'cancel_time' => (integer)$transaction->cancel_time,
                        'state' => $transaction->state,
                    ]
                ];
            }
            else{
                if($transaction->state == 2){
                    /*tekshirish kerak nimagadur*/
                    if(1 == 1){
                        $transaction->state = -2;
                        $transaction->reason = $reason;
                        $transaction->cancel_time = (string)round(microtime(true) * 1000); ///risk xatolik boliwi mumkin
                        $transaction->save();
                        return [
                            'result' => [
                                'transaction' => $transaction->paycom_transaction_id,
                                'cancel_time' => (integer)$transaction->cancel_time,
                                'state' => $transaction->state,
                            ]
                        ];
                    }
                    else{
                        return [
                            'jsonrpc' => "2.0", 
                            'error' => [
                                'code' => -31007,
                                'message' => "Заказ выполнен. Невозможно отменить транзакцию. Товар или услуга предоставлена покупателю в полном объеме."
                            ] 
                        ];
                    }
                }
                else{
                    return [
                        'result' => [
                            'transaction' => $transaction->paycom_transaction_id,
                            'cancel_time' => (integer)$transaction->cancel_time,
                            'state' => $transaction->state,
                        ]
                    ];
                }
            }
        }
    }

    public function GetStatement($id, $from, $to)
    {
        $result = [];
        $transactions = Transactions::find()->where(['between', 'paycom_time', $from, $to])->all();
        foreach ($transactions as $transaction) {
            $result [] = [
                'id' => $transaction->paycom_transaction_id,
                'time' => $transaction->paycom_time,
                'amount' => $transaction->amount,
                'account' => [
                    'order_id' => $transaction->order_id,
                ],
                'create_time' => $transaction->create_time,
                'perform_time' => $transaction->perform_time,
                'cancel_time' => $transaction->cancel_time,
                'transaction' => '',//$transaction->paycom_transaction_id,
                'state' => $transaction->state,
                'reason' => $transaction->reason,
                'receivers' => $transaction->receivers,
            ];
        }
        if($transactions == null){
            return [
                'jsonrpc' => "2.0", 
                'error' => [
                    'code' => -32504,
                    'message' => "Недостаточно привилегий для выполнения метода."
                ] 
            ];
        }

        return [
            'result' => [
                'transactions' => $result,
            ]
        ];
    }

    public function ChangePassword($password)
    {
        //$settings = Settings::find()->where(['key' => $password])->one();
        if(null == null){
            return [
                'jsonrpc' => "2.0", 
                'error' => [
                    'code' => -32504,
                    'message' => "Недостаточно привилегий для выполнения метода."
                ] 
            ];
        } else{
            /*$settings->value = $password;
            $settings->save();*/
        }
        return [
            'result' => [
                'success' => true
            ]
        ];   
    }
}