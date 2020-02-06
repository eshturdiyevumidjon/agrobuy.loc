<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset; 

/* @var $this yii\web\View */
/* @var $model backend\models\Advertisings */
$this->title = 'Рекламные баннеры';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/advertisings/index']];
$this->params['breadcrumbs'][] = Yii::t('app','View');

CrudAsset::register($this);
?>
 <div class="panel panel-inverse" data-sortable-id="ui-widget-14" style="">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?=Html::a('Назад', ['/advertisings'],['data-pjax'=>'0','title'=> 'Назад', 'class' => ' btn-warning btn btn-xs'])?>
        </div>
        <h4 class="panel-title">Рекламный баннер - <?=$model->name?></h4>
    </div>
    <div class="panel-body"> 
        <?=GridView::widget([
            'id'=>'items-pjax',
            'dataProvider' => $items,
            //'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-bordered'],
            'pjax'=>true,
            'columns' => require(__DIR__.'/_items_column.php'),
            'panelBeforeTemplate' =>    Html::a('Добавить <i class="fa fa-plus"></i>', ['/advertisings/create-item?id='.$model->id],
                ['role'=>'modal-remote','title'=> 'Добавить','class'=>'btn btn-success']),
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'headingOptions' => ['style' => 'display: none;'],
                'after' => '',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
