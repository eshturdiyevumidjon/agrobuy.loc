<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PriceList */
?>
<div class="price-list-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'price',
            'number',
        ],
    ]) ?>

</div>
