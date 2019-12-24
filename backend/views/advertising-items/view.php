<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AdvertisingItems */
?>
<div class="advertising-items-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'advertising_id',
            'title',
            'text:ntext',
            'link',
            'type',
            'file',
        ],
    ]) ?>

</div>
