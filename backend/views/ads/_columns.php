<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Ads;


return [
    /*[
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],*/
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'images',
        'format'=>'raw',
        'content'=>function($data){
            return $data->getImage('_columns');
        },
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_id',
        'filter' => Ads::getUsersList(),
        'content'=>function($data){
            return $data->getUsersList()[$data->user_id];
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
        'filter' => Ads::getType(),
        'content'=>function($data){
            return $data->getType()[$data->type];
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'category_id',
        'filter' => Ads::getCategoryList(),
        'content'=>function($data){
            return $data->getCategoryList()[$data->category_id];
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'subcategory_id',
        'filter' => Ads::getSubcategoryList(),
        'content'=>function($data){
            return $data->getSubcategoryList()[$data->subcategory_id];
        },
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'city_name',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'text',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'price',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'currency_id',
        'filter' => Ads::getCurrencyList(),
        'content'=>function($data){
            return $data->getCurrencyList()[$data->currency_id];
        },
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'old_price',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'unit_price',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'treaty',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'date_cr',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить', 
            // 'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
            // 'data-request-method'=>'post',
            'data-toggle'=>'tooltip',
            // 'data-confirm-title'=>'Подтвердите действие',
            // 'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?'
        ],
        'template' => '{view} {update} {leadDelete}',
        'viewOptions'=>['data-pjax'=>'0','title'=>'Просмотр','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Изменить', 'data-toggle'=>'tooltip'],
        'buttons'  => [
            'leadDelete' => function ($url, $model) {
                    $url = Url::to(['/ads/delete', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'role'=>'modal-remote','title'=>Yii::t('app','Delete'), 
                        'data-toggle'=>'tooltip',
                    ]);
            }, 
        ],
    ],

];   