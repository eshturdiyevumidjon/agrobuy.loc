<?php

$this->title = 'AgroBuy';
?>
    <?= $about_company->view_banners == 1 ? 
        $this->render('banners', [
            'nowLanguage' => $nowLanguage,
            'banners' => $banners,
        ]) : '' 
    ?>

    <?= $this->render('search', [
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

            <div class="reclama">
                <img src="<?=$reklama->getImage('main_page')?>" alt="<?=$reklama->title?>">
                <!-- <p><?php //$reklama->title?></p> -->
            </div>

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