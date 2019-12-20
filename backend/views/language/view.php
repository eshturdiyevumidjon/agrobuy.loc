<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Lang */
?>
<div class="lang-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'url:url',
            'local',
            'name',
            'image',
            'default',
            'create',
            'status',
            'date_update',
            'date_create',
        ],
    ]) ?>

</div>
