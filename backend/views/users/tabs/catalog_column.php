<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
    ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'images',
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'category_id',
        'content' => function($data){
            return $data->getCategoryList()[$data->category_id];
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'subcategory_id',
        'content' => function($data){
            return $data->getSubcategoryList()[$data->subcategory_id];
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
        'content' => function($data){
            return $data->getType()[$data->type];
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'city_name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'text',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'price',
        'content' => function($data){
            $oldPrice = '';
            if($data->old_price != null) $oldPrice = '<s>'.$data->old_price.'</s>';
            return $data->price . ' ' . $oldPrice;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'unit_price',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'treaty',
        'content' => function($data){
            return $data->getTreaty()[$data->treaty];
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_cr',
        'content' => function($data){
            return $data->getDate($data->date_cr);
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'visible' => false,
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>Yii::t('app','View'),'data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>Yii::t('app','Update'), 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>Yii::t('app','Delete'), 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>Yii::t('app','Are you sure?'),
                          'data-confirm-message'=>Yii::t('app','Are you sure want to delete this item?')
                      ], 

    ],

];   