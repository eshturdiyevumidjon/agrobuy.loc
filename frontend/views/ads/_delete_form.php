<?php 

use yii\helpers\Html;

?>
<?php echo Html::beginForm(['/ads/delete?id='.$model->id], 'post'); ?>
    <h2><?=Yii::t('app', "E'lonni o'chirish")?></h2>
    <p><?=Yii::t('app', "Siz haqiqatdan ham e'lonni o'chirmoqchimisiz?")?></p>
   	<div class="btn-service">
       	<button type="submit" class="btn-template"><?=Yii::t('app', "Ha")?></button>
    </div>
<?php echo Html::endForm(); ?>