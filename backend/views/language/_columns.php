<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    // [
    //     'contentOptions'=>['class'=>'text-center'],
    //     'headerOptions'=>['class'=>'text-center'],
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'url',
    //     'content'=>function($data){
    //         return $data->url." (".$data->local.")"."&nbsp&nbsp&nbsp&nbsp".Html::img('/backend/web'.$data->image, [ 'style' => 'height:55px;width:55px;' ]);
    //     }
    // ],
    [
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'local',
    ],
    [
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'attribute'=>'status',
        'width'=>'150px',
        'format'=>'raw',
        'value'=>function($data){
               return '<label class="switch switch-small">
                    <input type="checkbox"'. (($data->status == 1)?' checked=""':'""').(($data->default==2)?' disabled=""':'""').'value="'.$data->id.'" onchange="$.post(\'/admin/language/change-values\',{id:'.$data->id.'},function(data){ });">
                    <span></span>
                    </a>
                </label>';
            },
    ],
    [
        'class'    => 'kartik\grid\ActionColumn',
        'template' => ' {update} {leadDelete} {messages}',
        'viewOptions'=>['role'=>'modal-remote','title'=>Yii::t('app','View'),'data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>Yii::t('app','Edit'), 'data-toggle'=>'tooltip'],
        'buttons'  => [
            'messages' => function($url, $model){
                $url = Url::to(['/translations/source-message/', 'id' => $model->url]);
                 return Html::a('<span class="glyphicon glyphicon-book"></span>', $url, [
                          'data-pjax'=>0,'title'=>Yii::t('app','Translations'), 
                          'data-toggle'=>'tooltip'
                    ]);
            },
            'leadDelete' => function ($url, $model) {
                if($model->default == 0){
                    $url = Url::to(['/language/delete', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                          'role'=>'modal-remote','title'=>Yii::t('app','Delete'), 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>Yii::t('app','Are you sure?'),
                          'data-confirm-message'=>Yii::t('app','Are you sure want to delete this item?'),
                    ]);
                }
            },
        ]
    ],
    
];