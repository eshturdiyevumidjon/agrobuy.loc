<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Categories */

?>
<div class="categories-create">
    <?= $this->render('_form', [
        'model' => $model,
        'titles' => null,
        'post' => $post,
        'langs' => $langs,
    ]) ?>
</div>
