<?php

use yii\helpers\Html;

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?=Html::a('Назад', ['/news'],['data-pjax'=>'0','title'=> 'Назад', 'class' => ' btn-warning btn btn-xs'])?>
        </div>
        <h4 class="panel-title"><b>Новости</b></h4>
    </div>
    <div class="panel-body">
	    <?= $this->render('_form', [
	        'model' => $model,
            'sliderProvider' => [],
            'sortProvider' => [],
            'titles' => [],
            'texts' => [],
            'sort_title' => [],
            'sort_items' => [],
            'landing_title' => [],
            'landing_text' => [],
            'important' => [],
            'growing_title' => [],
            'growing_text' => [],
            'growing_items' => [],
            'description' => [],
	    ]) ?>
	</div>
</div>
