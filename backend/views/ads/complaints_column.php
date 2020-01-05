<?php
use yii\helpers\Url;
use common\models\PreferenceBooks;


return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_id',
        //'filter' => Ads::getUsersList(),
        'content'=>function($data){
            return $data->getUsersList()[$data->user_id];
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_from',
        'content'=>function($data){
            return $data->getUsersList()[$data->user_from];
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'text',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_cr',
        'content'=>function($data){
            return PreferenceBooks::getDateTime($data->date_cr);
        },
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'visible' => false,
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['data-pjax'=>'0','title'=>'Просмотр','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Изменить', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить', 
            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
            'data-request-method'=>'post',
            'data-toggle'=>'tooltip',
            'data-confirm-title'=>'Подтвердите действие',
            'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?'], 
    ],

];   