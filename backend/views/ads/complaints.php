<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\grid\GridView;

?>
<?php Pjax::begin(['enablePushState' => false, 'id' => 'complaints-pjax']); ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?=Html::a('Назад', ['/users'],['data-pjax'=>'0','title'=> 'Назад', 'class' => ' btn-warning btn btn-xs'])?>
        </div>
        <h4 class="panel-title"><b>Список</b></h4>
    </div>
    <div class="panel-body">
        <?=GridView::widget([
            'id'=>'users-catalog',
            'dataProvider' => $complaintsProvider,
            //'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-bordered'],
            'pjax'=>true,
            'columns' => require(__DIR__.'/complaints_column.php'),
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
</div>
<?php Pjax::end(); ?>
