<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
   // [
     //   'class' => 'kartik\grid\CheckboxColumn',
       // 'width' => '20px',
    //],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'image',
        'contentOptions' => ['style'=>'width: 48px; height:48px;'],
        'content' => function ($data) {
           if($data->image != null) return '<center>' . Html::img('/backend/web/uploads/promotions/'.$data->image, [ 'style' => 'height:48px;width:48px; object-fit: cover;']) . '</center>';
           else return '<center>' . Html::img('/backend/web/img/nouser.png', [ 'style' => 'height:48px;width:48px; object-fit: cover;']) . '</center>';
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'text',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'price',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'days',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'premium',
        'content' => function($data){
            return $data->getPremiumDescription();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'top',
        'content' => function($data){
            return $data->getTopDescription();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'discount',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{update}',
       
        'updateOptions'=>['role'=>'modal-remote','title'=>'Изменить', 'data-toggle'=>'tooltip'],
       
    ],

];   