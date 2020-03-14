<?php


?>
<div class="puy-tab-person">
    <div class="prem-vip">
    	<?php foreach ($promotions as $prom) { 
    		if($prom->id == 1) $key = 'top';
    		if($prom->id == 2) $key = 'premium';
    		?>
	        <div class="prem-vip-item">
	            <?php //if($prom->discount > 0) echo '<div class="prem-vip-discount">- ' . $prom->discount . '%</div>'?>
	            <div class="prem-vip-img">
	                <img src="<?=$prom->getImage('main_page')?>" alt="">
	            </div>
	            <!-- <a class="prem-vip-date promotion_tab" href="#" data-touch="false" value="/<?=$nowLanguage?>/profile/buy-promotion?id=<?=$prom->id?>" data-fancybox data-src="#ad-promotion" ><?=$prom->name?></a> -->
	            <a class="prem-vip-date" href="/<?=$nowLanguage?>/site/privacy?key=<?=$key?>" ><?=$prom->name?></a>
	            <p><?=$prom->text?></p>
	            <span class="prem-vip-price"><?=$prom->price?> <?= Yii::t('app',"So'm") ?></span>
	        </div>
    	<?php } ?>
    </div>
</div>