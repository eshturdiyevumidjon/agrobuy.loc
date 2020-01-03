<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ads */
?>
<div class="ads-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'type',
            'title',
            'images:ntext',
            'category_id',
            'subcategory_id',
            'city_name:ntext',
            'text:ntext',
            'price',
            'old_price',
            'unit_price',
            'treaty',
            'date_cr',
        ],
    ]) ?>

</div>
