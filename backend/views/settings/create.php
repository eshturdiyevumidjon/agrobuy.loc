<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\Settings */

$this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/settings/index']];
$this->params['breadcrumbs'][] = Yii::t('app','Create');
?>
 <div class="panel panel-inverse" data-sortable-id="ui-widget-14" style="">
    <div class="panel-heading">
        <h4 class="panel-title"><?=Yii::t('app','Create')?></h4>
    </div>
    <div class="panel-body">
            <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
    </div>
</div>
