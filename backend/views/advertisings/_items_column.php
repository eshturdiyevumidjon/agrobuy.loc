<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'file',
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
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'text',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'link',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
        'content'=>function($data){
            return $data->getType()[$data->type];
        },
    ],
    [
        'class'    => 'kartik\grid\ActionColumn',
        'template' => '{leadUpdate} {leadDelete}',
        'buttons'  => [
            'leadUpdate' => function ($url, $model) {
                $url = Url::to(['/advertisings/update-item', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'role'=>'modal-remote', 'data-toggle'=>'tooltip','title'=>'Изменить',]);
            },
            'leadDelete' => function ($url, $model) {
                $url = Url::to(['/advertisings/delete-item', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'role'=>'modal-remote','title'=>'Удалить', 
                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                    'data-request-method'=>'post',
                    'data-toggle'=>'tooltip',
                    'data-confirm-title'=>'Подтвердите действие',
                    'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?',
                ]);
            },
        ]
    ]

];   