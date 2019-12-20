<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Users;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
        'checkboxOptions' => function($model) {
            if($model->id == 1){
               return ['disabled' => true];
            }else{
               return [];
            }
         },
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'avatar',
        'contentOptions' => ['style'=>'width: 48px; height:48px;'],
        'content' => function ($data) {
           if($data->avatar != null) return '<center>' . Html::img('/backend/web/uploads/avatars/'.$data->avatar, [ 'style' => 'height:48px;width:48px; object-fit: cover;']) . '</center>';
           else return '<center>' . Html::img('/backend/web/img/nouser.png', [ 'style' => 'height:48px;width:48px; object-fit: cover;']) . '</center>';
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fio',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'login',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
        'visible'=> (Yii::$app->user->identity->id == 1) ? true : false,
        'filter' => [1 => 'Администратор',2 => 'Модератор',3 => 'Ползователь',4 => 'Образование'],
        'content' => function ($data) {
           return $data->getTypeDescription();
       },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{update} {leadDelete}',
        'buttons'  => [
            'leadDelete' => function ($url, $model) {
                if($model->id != 1){
                    $url = Url::to(['/users/delete', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'role'=>'modal-remote','title'=>'Удалить', 
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-toggle'=>'tooltip',
                        'data-confirm-title'=>'Подтвердите действие',
                        'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?'
                    ]);
                }
            },
        ],
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Просмотр','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Изменить', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Подтвердите действие',
                          'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?'], 
    ],

];   