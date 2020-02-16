<?php

$this->title = 'AgroBuy';
?>
    <?= $about_company->view_banners == 1 ? 
        $this->render('banners', [
            'nowLanguage' => $nowLanguage,
            'banners' => $banners,
        ]) : '' 
    ?>

    <?= $this->render('filtr', [
        'regions' => $regions,
        'nowLanguage' => $nowLanguage,
        'categories' => $categories,
    ]) ?>
  
    <?= $this->render('join', [
        'nowLanguage' => $nowLanguage,
    ]) ?>

    <?= $this->render('categories', [
        'nowLanguage' => $nowLanguage,
        'categories' => $categories,
    ]) ?>

    <?= count($premiumAds) > 0 ? 
        $this->render('premium', [
            'nowLanguage' => $nowLanguage,
            'premiumAds' => $premiumAds,
            'favorites' => $favorites,
        ])  : '' ?>

    <section class="trust-him">
        <div class="container">
        
            <?= count($trustedAds) > 0 ? 
                $this->render('trusted', [
                    'nowLanguage' => $nowLanguage,
                    'trustedAds' => $trustedAds,
                    'favorites' => $favorites,
                ]) : '' 
            ?>

            <div class="swiper-container reclama">
            <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <?php foreach ($reklama as $value) { ?>
                        <a href="<?=$value->link?>" class="swiper-slide" data-swiper-autoplay="<?=$value->advertising->time * 1000 ?>">
                            <img src="<?=$value->getImage('main_page')?>" alt="<?=$value->title?>">
                        </a>
                    <?php } ?>
                </div>
            </div>
            <!-- <div class="reclama">
                <img src="<?php //$reklama->getImage('main_page')?>" alt="<?=$reklama->title?>">
                <p><?php //$reklama->title?></p>
            </div> -->

            <?= count($newAds) > 0 ? 
                $this->render('new_ads', [
                    'nowLanguage' => $nowLanguage,
                    'newAds' => $newAds,
                    'favorites' => $favorites,
                ]): '' 
            ?>

        </div>
    </section>

    <?= $this->render('news', [
        'nowLanguage' => $nowLanguage,
        'news' => $news,
    ]) ?>