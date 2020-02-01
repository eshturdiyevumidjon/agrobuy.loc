<?php

$this->title = 'AgroBuy';
?>
    <?= $about_company->view_banners == 1 ? 
        $this->render('banners', [
            'banners' => $banners,
        ]) : '' 
    ?>

    <?= $this->render('search', [
        'categories' => $categories,
    ]) ?>
  
    <?= $this->render('join', [
        //'banners' => $banners,
    ]) ?>

    <?= $this->render('categories', [
        'categories' => $categories,
    ]) ?>

    <?= $this->render('premium', [
        //'banners' => $banners,
    ]) ?>

    <section class="trust-him">
        <div class="container">
        
            <?= $this->render('trusted', [
                //'banners' => $banners,
            ]) ?>

            <div class="reclama">
                <img src="images/logo.png" alt="">
                <p>Реклама</p>
            </div>

            <?= $this->render('new_Ads', [
                //'banners' => $banners,
            ]) ?>

        </div>
    </section>

    <?= $this->render('news', [
        'news' => $news,
    ]) ?>