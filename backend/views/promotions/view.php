<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Promotions */
?>
<div class="promotions-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'text:ntext',
            'price',
            'days',
            'premium',
            'top',
            'discount',
        ],
    ]) ?>

</div>
