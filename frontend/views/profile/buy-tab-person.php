<?php


?>
<div class="puy-tab-person">
    <div class="prem-vip">
    	<?php foreach ($promotions as $prom) { ?>
	        <div class="prem-vip-item">
	            <?php if($prom->discount > 0) echo '<div class="prem-vip-discount">- ' . $prom->discount . '%</div>'?>
	            <div class="prem-vip-img">
	                <img src="<?=$prom->getImage('main_page')?>" alt="">
	            </div>
	            <a class="prem-vip-date"><?=$prom->name?></a>
	            <p><?=$prom->text?></p>
	            <span class="prem-vip-price"><?=$prom->price?> <?= Yii::t('app',"So'm") ?></span>
	        </div>
    	<?php } ?>
    </div>
</div>