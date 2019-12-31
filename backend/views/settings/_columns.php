<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
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
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'key',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'value',
        'value'=>function($data){
            if(strlen($data->value) > 200){
                return substr($data->value,0,200)."...";
            }
            else
                return $data->value;
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'priority',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'view_in_footerser_id',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view} {update}',
    ],
];   

