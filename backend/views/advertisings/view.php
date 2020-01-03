<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Advertisings */
$this->title = 'Рекламные баннеры';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/advertisings/index']];
$this->params['breadcrumbs'][] = Yii::t('app','View');
?>
 <div class="panel panel-inverse" data-sortable-id="ui-widget-14" style="">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?=Html::a('<i class="fa fa-pencil"></i>', ['/users/change-personal?id='.$model->id.'&type=1'],['role'=>'modal-remote','title'=> 'Изменить', 'class' => 'btn-sm btn-icon btn-circle btn-info'])?>
            <?=Html::a('Назад', ['/advertisings'],['data-pjax'=>'0','title'=> 'Назад', 'class' => ' btn-warning btn btn-xs'])?>
        </div>
        <h4 class="panel-title"><?=Yii::t('app','View')?></h4>
    </div>
    <div class="panel-body">
    	
<div class="advertisings-view">
 
        <?=GridView::widget([
            'id'=>'users-catalog',
            'dataProvider' => $items,
            //'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-bordered'],
            'pjax'=>true,
            'columns' => require(__DIR__.'/_items_column.php'),
            'panelBeforeTemplate' => false,
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'headingOptions' => ['style' => 'display: none;'],
                'after' => '',
            ]
        ])?>

</div>
