<?php

  use yii\helpers\Url;
  use yii\helpers\Html;
  use yii\widgets\Pjax;
  $nowLanguageName = '';
?>

<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-9">
              <a href="/" class="logo"><img src="<?=$path?>" alt="Logo"></a>          
            </div>
            <div class="col-lg-9 col-md-8 col-3 justify-content-end d-flex align-items-center">
              <div class="mob-language">
                  <div class="languages-group">
                  <?php 
                      foreach ($langs as $lang) { 
                      if($lang['url'] == $nowLanguage) $nowLanguageName = $lang['local'];
                  ?>
                      <a href="<?= Url::to([ '/' .$pathInfo . '?' . $urlParams, 'language' => $lang['url']]) ?>" class="<?=$lang['class']?>"><?=$lang['local']?></a>
                  <?php  } ?>
                  </div>
                  <span class="d-sm-none"><?=$nowLanguageName?></span>
              </div>
              <?php if(Yii::$app->user->isGuest) { ?>
                  <a href="#" data-touch="false" data-fancybox data-src="#avtorization" value="/<?=$nowLanguage?>/site/login" class="btn-template avtorization_class">
                    <span style="background-image: url(/images/icon-user.png);"></span> <?= Yii::t('app',"E'lon qo'shish") ?>
                  </a>
              <?php } else { ?>
                  <a href="/ads/create" class="btn-template"><?= Yii::t('app',"E'lon qo'shish") ?></a>
              <?php } ?>

              <?php if(Yii::$app->user->isGuest) { ?>
                  <a href="javascript;" data-touch="false" data-fancybox data-src="#avtorization" value="/<?=$nowLanguage?>/site/login" class="entor-to-site avtorization_class">
                    <span style="background-image: url(/images/icon-user.png);"></span><?= Yii::t('app',"Kirish") ?>
                  </a>
              <?php } else { ?>
                  <?php if(Yii::$app->controller->id == 'profile') { ?>
                    <a class="btn btn_exit d-sm-block d-none" data-touch="false" data-fancybox data-src="#logout-popup" ><?=Yii::t('app', "Chiqish")?></a>
                  <?php } ?>
                    <a href="/profile" class="entor-to-site">
                        <span style="background-image: url(/images/icon-user.png);"></span><?= Yii::t('app',"Profil") ?>
                        <?php Pjax::begin(['id' => 'profile-chat-pjax']); ?>
                            <div class="chat_message_count"><?=Yii::$app->user->identity->getChatMessageCount()?></div>
                        <?php Pjax::end(); ?> 
                    </a>
              <?php } ?>
            </div>
        </div>
        <div class="d-md-none form-search-mobile">
            <form class="form-sit" action="/site/search" method="get">
              <!-- <input type="text" placeholder="<?php // Yii::t('app',"Sayt bo'yicha qidirish") ?>" class="form-control"> -->
              <input type="text" class="form-control" name="text" placeholder="<?= Yii::t('app',"So'rovingizni kiriting") ?>">
              <button type="submit" style="background-image: url(/images/magnifier.png);"></button>
            </form>
            <a href="#" class="open-filter"><?= Yii::t('app',"Filtrlar") ?></a>
        </div>
    </div>
    <div class="hdr-bottom d-md-none">
        <ul>
            <li>
              <a href="/" class="<?=$pathInfo == 'site/index' || $pathInfo == '' ? 'active' : ''?>">
                  <!DOCTYPE svg  PUBLIC '-//W3C//DTD SVG 1.1//EN'  'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'>
                  <svg enable-background="new 0 0 495.398 495.398" version="1.1" viewBox="0 0 495.4 495.4" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                    <path d="m487.08 225.51-75.08-75.08v-86.73c0-15.682-12.708-28.391-28.413-28.391-15.669 0-28.377 12.709-28.377 28.391v29.941l-55.903-55.905c-27.639-27.624-75.694-27.575-103.27 0.05l-187.73 187.72c-11.082 11.104-11.082 29.071 0 40.158 11.087 11.101 29.089 11.101 40.172 0l187.71-187.73c6.115-6.083 16.893-6.083 22.976-0.018l187.74 187.75c5.567 5.551 12.825 8.312 20.081 8.312 7.271 0 14.541-2.764 20.091-8.312 11.086-11.086 11.086-29.053-1e-3 -40.158z"/>
                    <path d="m257.56 131.84c-5.454-5.451-14.285-5.451-19.723 0l-165.13 165.08c-2.607 2.606-4.085 6.164-4.085 9.877v120.4c0 28.253 22.908 51.16 51.16 51.16h81.754v-126.61h92.299v126.61h81.755c28.251 0 51.159-22.907 51.159-51.159v-120.4c0-3.713-1.465-7.271-4.085-9.877l-165.11-165.08z"/>
                  </svg>
                  <span><?= Yii::t('app',"Bosh S.") ?></span>
              </a>
            </li>
            <?php if(Yii::$app->user->isGuest) { ?>
              <li>
                <a href="#" data-touch="false" data-fancybox data-src="#avtorization" value="/<?=$nowLanguage?>/site/login" class="avtorization_class">
                    <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M467,61H45C20.218,61,0,81.196,0,106v300c0,24.72,20.128,45,45,45h422c24.72,0,45-20.128,45-45V106    C512,81.28,491.872,61,467,61z M460.786,91L256.954,294.833L51.359,91H460.786z M30,399.788V112.069l144.479,143.24L30,399.788z     M51.213,421l144.57-144.57l50.657,50.222c5.864,5.814,15.327,5.795,21.167-0.046L317,277.213L460.787,421H51.213z M482,399.787    L338.213,256L482,112.212V399.787z"/>
                    </svg>
                    <span><?= Yii::t('app',"Chat") ?></span>
                </a>
              </li>
              <li>
                <a href="#" data-touch="false" data-fancybox data-src="#avtorization" value="/<?=$nowLanguage?>/site/login" class="avtorization_class">
                    <!DOCTYPE svg  PUBLIC '-//W3C//DTD SVG 1.1//EN'  'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'>
                    <svg enable-background="new 0 0 350 350" version="1.1" viewBox="0 0 350 350" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m175 171.17c38.914 0 70.463-38.318 70.463-85.586 0-47.269-10.358-85.587-70.463-85.587s-70.465 38.318-70.465 85.587c0 47.268 31.549 85.586 70.465 85.586z"/><path d="m41.909 301.85c-0.012-2.882-0.024-0.812 0 0z"/><path d="m308.08 304.1c0.038-0.789 0.013-5.474 0 0z"/><path d="m307.94 298.4c-1.305-82.342-12.059-105.8-94.352-120.66 0 0-11.584 14.761-38.584 14.761s-38.586-14.761-38.586-14.761c-81.395 14.69-92.803 37.805-94.303 117.98-0.123 6.547-0.18 6.891-0.202 6.131 5e-3 1.424 0.011 4.058 0.011 8.651 0 0 19.592 39.496 133.08 39.496 113.49 0 133.08-39.496 133.08-39.496 0-2.951 2e-3 -5.003 5e-3 -6.399-0.022 0.47-0.066-0.441-0.149-5.708z"/>
                    </svg>
                    <span><?= Yii::t('app',"Profil") ?></span>
                </a>
              </li>
              <li class="user-li no-user">
                  <a href="#" data-touch="false" data-fancybox data-src="#avtorization" value="/<?=$nowLanguage?>/site/login" class="avtorization_class avt_reg">
                    <span></span>
                    <?= Yii::t('app',"Kirish") ?>
                  </a>
              </li>
          <?php } else { ?>
            <li>
              <a href="/chat" class="<?=Yii::$app->controller->id == 'chat' ? 'active' : ''?>">
                  <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M467,61H45C20.218,61,0,81.196,0,106v300c0,24.72,20.128,45,45,45h422c24.72,0,45-20.128,45-45V106    C512,81.28,491.872,61,467,61z M460.786,91L256.954,294.833L51.359,91H460.786z M30,399.788V112.069l144.479,143.24L30,399.788z     M51.213,421l144.57-144.57l50.657,50.222c5.864,5.814,15.327,5.795,21.167-0.046L317,277.213L460.787,421H51.213z M482,399.787    L338.213,256L482,112.212V399.787z"/>
                  </svg>
                  <span><?= Yii::t('app',"Chat") ?></span>
                  <?php Pjax::begin(['id' => 'mobile-chat-pjax']); ?>
                      <div class="chat_message_count"><?=Yii::$app->user->identity->getChatMessageCount()?></div>
                  <?php Pjax::end(); ?>
              </a>
            </li>
            <li>
              <a href="/profile" class="<?=Yii::$app->controller->id == 'profile' ? 'active' : ''?>">
                  <!DOCTYPE svg  PUBLIC '-//W3C//DTD SVG 1.1//EN'  'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'>
                  <svg enable-background="new 0 0 350 350" version="1.1" viewBox="0 0 350 350" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m175 171.17c38.914 0 70.463-38.318 70.463-85.586 0-47.269-10.358-85.587-70.463-85.587s-70.465 38.318-70.465 85.587c0 47.268 31.549 85.586 70.465 85.586z"/><path d="m41.909 301.85c-0.012-2.882-0.024-0.812 0 0z"/><path d="m308.08 304.1c0.038-0.789 0.013-5.474 0 0z"/><path d="m307.94 298.4c-1.305-82.342-12.059-105.8-94.352-120.66 0 0-11.584 14.761-38.584 14.761s-38.586-14.761-38.586-14.761c-81.395 14.69-92.803 37.805-94.303 117.98-0.123 6.547-0.18 6.891-0.202 6.131 5e-3 1.424 0.011 4.058 0.011 8.651 0 0 19.592 39.496 133.08 39.496 113.49 0 133.08-39.496 133.08-39.496 0-2.951 2e-3 -5.003 5e-3 -6.399-0.022 0.47-0.066-0.441-0.149-5.708z"/>
                  </svg>
                  <span><?= Yii::t('app',"Profil") ?></span>
              </a>
            </li>
            <li class="user-li no-user">
                <a class="avt_reg btn_exit" data-touch="false" data-fancybox data-src="#logout-popup">
                  <span></span>
                  <?= Yii::t('app',"Chiqish") ?>
                </a>
            </li>
          <?php } ?>
    </ul>
    </div>
</header>