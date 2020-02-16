<?php

	use yii\helpers\Html;
  use yii\helpers\Url;

$pathInfo = Yii::$app->request->pathInfo;
$siteName = Yii::$app->params['siteName'];
$urlParams = Yii::$app->getRequest()->getQueryString();

$title = $identity->fio; // заголовок
$summary = 'Каталог пользователья'; // анонс поста
$url = Url::to([ '/' .$pathInfo . '?' . $urlParams, 'language' => $lang['url']]); // ссылка на пост
$image_url = $identity->getAvatarForSite(); // URL изображения

?>

<section class="catalog">
    <div class="container">
        <div class="swiper-container reclama">
            <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <?php foreach ($reklama as $value) { ?>
                        <a href="<?=$value->link?>" class="swiper-slide" <?=$value->advertising->time * 1000 ?>>
                            <img src="<?=$value->getImage('main_page')?>" alt="<?=$value->title?>">
                        </a>
                    <?php } ?>
                </div>
            </div>
        <div class="block-main-user border-all">
          	<a href="<?=$path?>" class="img-main-user">
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
	            <!-- <a href="#" class="btn-template link-btn"><?php // Yii::t('app',"Katalogni baham ko'ring") ?></a> -->
              <div class="dropdown share_button">
                <button class="btn btn-secondary dropdown-toggle btn-template link-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?= Yii::t('app',"Katalogni baham ko'ring") ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a href="https://telegram.me/share/url?url=<?php echo $siteName . urlencode( $url ); ?>&text=<?php echo $summary . ' : ' . $title ?>" onclick="window.open(this.href, this.title, 'toolbar=0, status=0, width=548, height=325'); return false" title="Поделиться ссылкой на Телеграм" target="_parent" class="dropdown-item">
                      <svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m9.417 15.181-.397 5.584c.568 0 .814-.244 1.109-.537l2.663-2.545 5.518 4.041c1.012.564 1.725.267 1.998-.931l3.622-16.972.001-.001c.321-1.496-.541-2.081-1.527-1.714l-21.29 8.151c-1.453.564-1.431 1.374-.247 1.741l5.443 1.693 12.643-7.911c.595-.394 1.136-.176.691.218z"></path></svg>
                      Telegram
                  </a>
                 <!--  <a class="dropdown-item" href="#">
                      <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                <path d="M352,0H160C71.648,0,0,71.648,0,160v192c0,88.352,71.648,160,160,160h192c88.352,0,160-71.648,160-160V160    C512,71.648,440.352,0,352,0z M464,352c0,61.76-50.24,112-112,112H160c-61.76,0-112-50.24-112-112V160C48,98.24,98.24,48,160,48    h192c61.76,0,112,50.24,112,112V352z"></path>
                                <path d="m256 128c-70.688 0-128 57.312-128 128s57.312 128 128 128 128-57.312 128-128-57.312-128-128-128zm0 208c-44.096 0-80-35.904-80-80 0-44.128 35.904-80 80-80s80 35.872 80 80c0 44.096-35.904 80-80 80z"></path>
                                <circle cx="393.6" cy="118.4" r="17.056"></circle>
                            </svg>
                      Instagram
                  </a> -->
                  <a href="http://www.facebook.com/sharer.php?s=100&p[url]=<?php echo urlencode( $url ); ?>&p[title]=<?php echo $title ?>&p[summary]=<?php echo $summary ?>&p[images][0]=<?php echo $image_url ?>" onclick="window.open(this.href, this.title, 'toolbar=0, status=0, width=548, height=325'); return false" title="Поделиться ссылкой на Фейсбук" target="_parent" class="dropdown-item">
                      <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                <path d="M288,176v-64c0-17.664,14.336-32,32-32h32V0h-64c-53.024,0-96,42.976-96,96v80h-64v80h64v256h96V256h64l32-80H288z"></path>
                            </svg>
                      Facebook
                  </a>
                </div>
              </div>
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