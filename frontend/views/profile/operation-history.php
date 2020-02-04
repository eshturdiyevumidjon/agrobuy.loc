<?php


?>

<div class="operation-history">
    <div class="history-title">
        <div><?= Yii::t('app',"Operatsiya") ?></div>
        <div><?= Yii::t('app',"Yaratilgan vaqti") ?></div>
        <div><?= Yii::t('app',"E'lon nomeri") ?></div>
        <div><?= Yii::t('app',"Summa") ?></div>
    </div>
    <div class="history-body">
    	<?php foreach ($history as $hist) { ?>
    		<?php if($hist->type == 1) { ?>
		        <div class="history-body-item">
		          	<div><?= Yii::t('app',"Hisobni to'ldirish") ?></div>
		          	<div><?= date('d.m.Y', strtotime($hist->date_cr) ) ?> <span class="ascii-dot"></span> <?= date('H:i', strtotime($hist->date_cr) ) ?></div>
		          	<div></div>
		          	<div><?=$hist->summa?> <?= Yii::t('app',"So'm") ?></div>
		        </div>
		    <?php } if($hist->type == 2)  { $prom = $hist->getPromotion(); ?>
		        <div class="history-body-item">
		          	<div class="greens">
		            	<div class="prem-vip-discount"><?=$prom->name?></div>
		            	<img src="<?=$prom->getImage('main_page')?>" alt="">
		          	</div>
		          	<div><?= date('d.m.Y', strtotime($hist->date_cr) ) ?> <span class="ascii-dot"></span> <?= date('H:i', strtotime($hist->date_cr) ) ?></div>
		          	<div>№ <?=$hist->field_id?></div>
		          	<div><?=$hist->summa?> <?= Yii::t('app',"So'm") ?></div>
		        </div>
	    	<?php } ?>
    	<?php } ?>
    </div>
</div>