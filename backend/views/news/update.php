<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\News */
?>
<div class="news-update">

    <?= $this->render('_form', [
        'model' => $model,
        'titles'=>$titles,
        'texts'=>$texts,
    ]) ?>

</div>
