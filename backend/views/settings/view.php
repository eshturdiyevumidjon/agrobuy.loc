<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Settings */
?>
<div class="settings-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'key',
            'value:ntext',
            'priority',
            'view_in_footerser_id',
        ],
    ]) ?>

</div>
