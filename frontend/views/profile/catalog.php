<?php
	
?>

<section class="catalog">
    <div class="container">
        <div class="reclama">
          	<img src="<?=$reklama->getImage('main_page')?>" alt="<?=$reklama->title?>">
        </div>
        <div class="block-main-user border-all">
          	<a href="#" class="img-main-user">
            	<img src="<?=$identity->getAvatarForSite()?>" alt="User Avatar">
          	</a>
          	<div class="about-main-user">
            	<div class="about-main-user-top">
              		<h2><?=$identity->fio?></h2>
            	</div>
            	<div class="about-main-user-bottom mob-abs-right">
              		<div>
                		<p><?= Yii::t('app',"Login") ?> : <span><?=$identity->login?></span></p>
                		<p><?= Yii::t('app',"Kompaniya nomi") ?> : <span><?=$identity->company_name?></span></p>
                		<p><?= Yii::t('app',"ID") ?> : <span><?=$identity->id?></span></p>
              		</div>
            	</div>
          	</div>
          	<div class="about-main-user-right width-btn">
	            <a href="#" class="btn-template link-btn"><?= Yii::t('app',"Katalogni baham ko'ring") ?></a>
          	</div>
        </div>        
        <?= $this->render('search', [
          	'regions' => $regions,
            'cat' => $cat,
            'reg' => $reg,
            'get' => $get,
  	        'nowLanguage' => $nowLanguage,
  	        'categories' => $categories,
  	    ]) ?>
    </div>
</section>

<?= $this->render('premium', [
    'nowLanguage' => $nowLanguage,
    'dataProvider' => $dataProvider,
]) ?>