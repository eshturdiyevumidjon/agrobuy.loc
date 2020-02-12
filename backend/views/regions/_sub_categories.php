<?php
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<?=GridView::widget([ 
    'id'=>'crud-datatable',
    'dataProvider' => $model->SubCategoryList,
    'columns' => [
        [
            'class' => 'kartik\grid\SerialColumn',
            'width' => '30px',
        ],
        [
            'attribute' => 'name',
            'value' => function($data){
                return $data->name;
            }
        ],
        [
            'class'    => 'kartik\grid\ActionColumn',
            'template' => '{leadUpdate} {leadDelete}',
            'buttons'  => [
                'leadUpdate' => function ($url, $model) {
                    $url = Url::to(['/regions/update-sub', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'role'=>'modal-remote', 'data-toggle'=>'tooltip','title'=>'Изменить',]);
                },
                'leadDelete' => function ($url, $model) {
                    $url = Url::to(['/regions/delete-sub', 'id' => $model->id]);
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
    ],
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
])?>
