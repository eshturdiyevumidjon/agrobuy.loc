<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Advertisings */
$this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/settings/index']];
$this->params['breadcrumbs'][] = Yii::t('app','View');
?>
 <div class="panel panel-inverse" data-sortable-id="ui-widget-14" style="">
    <div class="panel-heading">
        <h4 class="panel-title"><?=Yii::t('app','View')?></h4>
    </div>
    <div class="panel-body">
    	
<div class="advertisings-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'key',
        ],
    ]) ?>

</div>
