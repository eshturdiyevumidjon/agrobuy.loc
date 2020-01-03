<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'label'=>Yii::t('app','Image'),
        'format'=>'raw',
        'content'=>function($data){
            return $data->getImage('_columns');
        },
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
    ],
     [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'text',
        'format'=>'raw',
        'value'=>function($data){
            if(strlen($data->text) > 200){
                return substr($data->text,0,200).Html::a('...', ['view','id'=>$data->id],
                    ['role'=>'modal-remote','title'=> Yii::t('app','More'),'class'=>'btn btn-link']);
            }
            else
                return $data->text;
        },
    ],
   
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date',
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>Yii::t('app','Просмотр'),'data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>Yii::t('app','Изменить'), 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>Yii::t('app','Удалить'), 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>Yii::t('app','Подтвердите действие'),
                          'data-confirm-message'=>Yii::t('app','Вы уверены что хотите удалить этого элемента?')], 
    ],

];   