<?php 

use yii\helpers\Html;

?>
<?php echo Html::beginForm(['/chat/delete?id='.$model->id], 'post'); ?>
    <h2><?=Yii::t('app', "O'chirish")?></h2>
    <p><?=Yii::t('app', "Siz haqiqatdan ham chatni o'chirmoqchimisiz?")?></p>
   	<div class="btn-service">
       	<button type="submit" class="btn-template"><?=Yii::t('app', "Ha")?></button>
    </div>
<?php echo Html::endForm(); ?>