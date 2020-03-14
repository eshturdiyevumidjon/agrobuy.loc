<?php

	use yii\helpers\Html;
  use yii\helpers\Url;

$pathInfo = Yii::$app->request->pathInfo;
$siteName = Yii::$app->params['siteName'];
$urlParams = Yii::$app->getRequest()->getQueryString();

$title = $identity->login; // заголовок
$summary = 'Каталог пользователья'; // анонс поста
//$url = Url::to([ '/' .$pathInfo . '?' . $urlParams, 'language' => $lang['url']]); // ссылка на пост
$url = Url::to([ '/' .$pathInfo, 'language' => $lang['url']]); // ссылка на пост
$image_url = $identity->getAvatarForSite(); // URL изображения

$this->title = $summary;
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
          	<a href="<?=$path?>" class="img-main-user avatar_user_img">
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
              <div class="dropdown share_button">
                <button class="btn btn-secondary dropdown-toggle btn-template link-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?= Yii::t('app',"Katalogni baham ko'ring") ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a href="https://telegram.me/share/url?url=<?php echo $siteName . urlencode( $url ); ?>&text=<?php echo $summary . ' : ' . $title ?>" onclick="window.open(this.href, this.title, 'toolbar=0, status=0, width=548, height=325'); return false" title="Поделиться ссылкой на Телеграм" target="_parent" class="dropdown-item">
                      <svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m9.417 15.181-.397 5.584c.568 0 .814-.244 1.109-.537l2.663-2.545 5.518 4.041c1.012.564 1.725.267 1.998-.931l3.622-16.972.001-.001c.321-1.496-.541-2.081-1.527-1.714l-21.29 8.151c-1.453.564-1.431 1.374-.247 1.741l5.443 1.693 12.643-7.911c.595-.394 1.136-.176.691.218z"></path></svg>
                      Telegram
                  </a>
                  <a href="http://www.facebook.com/sharer.php?s=100&p[url]=<?php echo urlencode( $url ); ?>&p[title]=<?php echo $title ?>&p[summary]=<?php echo $summary ?>&p[images][0]=<?php echo $image_url ?>" onclick="window.open(this.href, this.title, 'toolbar=0, status=0, width=548, height=325'); return false" title="Поделиться ссылкой на Фейсбук" target="_parent" class="dropdown-item">
                      <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                <path d="M288,176v-64c0-17.664,14.336-32,32-32h32V0h-64c-53.024,0-96,42.976-96,96v80h-64v80h64v256h96V256h64l32-80H288z"></path>
                            </svg>
                      Facebook
                  </a>
                  <a href="/" onclick=" return false;" class="dropdown-item">
                    <div id="bosss_profil">
                      <svg class="svg-icon" viewBox="0 0 20 20" id="copy_current_address">
                      <path fill="gray" d="M18.378,1.062H3.855c-0.309,0-0.559,0.25-0.559,0.559c0,0.309,0.25,0.559,0.559,0.559h13.964v13.964
                        c0,0.309,0.25,0.559,0.559,0.559c0.31,0,0.56-0.25,0.56-0.559V1.621C18.938,1.312,18.688,1.062,18.378,1.062z M16.144,3.296H1.621
                        c-0.309,0-0.559,0.25-0.559,0.559v14.523c0,0.31,0.25,0.56,0.559,0.56h14.523c0.309,0,0.559-0.25,0.559-0.56V3.855
                        C16.702,3.546,16.452,3.296,16.144,3.296z M15.586,17.262c0,0.31-0.25,0.558-0.56,0.558H2.738c-0.309,0-0.559-0.248-0.559-0.558
                        V4.972c0-0.309,0.25-0.559,0.559-0.559h12.289c0.31,0,0.56,0.25,0.56,0.559V17.262z"></path>
                    </svg>
                    Копировать ссылку
                    </div>
                 </a>
                </div>
              </div>
          	</div>
        </div>
        <?= $this->render('search', [
          	'districts' => $districts,
            'cat' => $cat,
            'dist' => $dist,
            'get' => $get,
            'user_id' => $user_id,
  	        'nowLanguage' => $nowLanguage,
  	        'categories' => $categories,
  	    ]) ?>
    </div>
</section>

<?= $this->render('premium', [
    'nowLanguage' => $nowLanguage,
    'dataProvider' => $dataProvider,
]) ?>

<?php
$this->registerJs(<<<JS
  $(document).on('click', '#bosss_profil', function(e){ 
      const el = document.createElement('input');  // Create a <textarea> element
      el.value = window.location.href;                                 // Set its value to the string that you want copied
      el.setAttribute('readonly', '');                // Make it readonly to be tamper-proof
      el.style.position = 'absolute';                 
      el.style.left = '-9999px';                      // Move outside the screen to make it invisible
      document.body.appendChild(el);                  // Append the <textarea> element to the HTML document
      const selected =            
        document.getSelection().rangeCount > 0        // Check if there is any content selected previously
          ? document.getSelection().getRangeAt(0)     // Store selection if found
          : false;                                    // Mark as false to know no selection existed before
      el.select();                                    // Select the <textarea> content
      document.execCommand('copy');                   // Copy - only works as a result of a user action (e.g. click events)
      document.body.removeChild(el);                  // Remove the <textarea> element
      if (selected) {                                 // If a selection existed before copying
        document.getSelection().removeAllRanges();    // Unselect everything on the HTML document
        document.getSelection().addRange(selected);   // Restore the original selection
      }
  });
JS
);
?>
