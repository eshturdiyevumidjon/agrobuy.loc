<?php

	use yii\halpers\Html;
?>  

<nav aria-label="breadcrumb" class="breadcrumb-top">
    <ol class="breadcrumb container">
        <li class="breadcrumb-item"><a href="#">Главная </a><img src="/images/right-arrow-green.png" alt=""></li>
        <li class="breadcrumb-item active" aria-current="page">Личный кабинет</li>
    </ol>
</nav>
     

<section class="personal-area">
    <div class="container">
        <?= $this->render('main-block-user', [
	        'nowLanguage' => $nowLanguage,
	        'identity' => $identity,
	    ]) ?>
        <div class="personal-tab">
          <ul class="nav nav-tabs">
            <li><a href="#firsttab" data-toggle="tab" class="active"><?= Yii::t('app',"Mening e'lonlarim") ?></a></li>
            <li><a href="#secondtab" data-toggle="tab"><?= Yii::t('app',"Sevimlilarim") ?></a></li>
            <li><a href="#thirdtab" data-toggle="tab"><?= Yii::t('app',"Pullik xizmatlar") ?></a></li>
            <li><a href="#fourthtab" data-toggle="tab"><?= Yii::t('app',"Operatsiyalar tarixi") ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane in active" id="firsttab">
              <?= $this->render('tab-my-ads', [
		            'myAds' => $myAds,
		        	'nowLanguage' => $nowLanguage,
		        	'favorites' => $favorites,
              ]) ?>
            </div>
            <div class="tab-pane fade" id="secondtab">
              <?= $this->render('tab-favorites-ads', [
                  'nowLanguage' => $nowLanguage,
                  'favoriteAds' => $favoriteAds,
              ]) ?>
            </div>
            <div class="tab-pane fade" id="thirdtab">
              <?= $this->render('buy-tab-person', [
                  /*'nowLanguage' => $nowLanguage,
                  'categories' => $categories,*/
              ]) ?>
            </div>
            <div class="tab-pane fade" id="fourthtab">
                <?= $this->render('operation-history', [
                  /*'nowLanguage' => $nowLanguage,
                  'categories' => $categories,*/
              ]) ?>
            </div>
          </div>
        </div>
    </div>
</section>