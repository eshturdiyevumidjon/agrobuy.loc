 <footer>
      <div class="ftr-top">
        <div class="container">
          <div class="row">
            <div class="col-lg-3 col-md-6">
              <a href="/" class="logo-ftr"><img src="<?=$path?>" alt="Logo"></a>
              <?=$session->getTerms(0)?>
              <!-- <a href="#" class="privacy-policy">Политика конфинденциальности</a> -->
            </div>
            <div class="col-lg-3 col-md-6 border-mobile">
              <ul>
                <li><?=$session->getTerms(1)?></li>
                <li><?=$session->getTerms(2)?></li>
                <li><?=$session->getTerms(3)?></li>
              </ul>
            </div>
            <div class="col-lg-3 col-md-6 border-mobile">
              <ul>
                <li><?=$session->getTerms(4)?></li>
                <li><?=$session->getTerms(5)?></li>
                <li><?=$session->getTerms(6)?></li>
              </ul>
            </div>
            <div class="col-lg-3 col-md-6">
              <ul>
                <li><?=$session->getTerms(7)?></li>
                <li><?=$session->getTerms(8)?></li>
                <li><?=$session->getTerms(9)?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="ftr-bottom">
        <div class="container">
          <div class="row">
            <div class="col-lg-3 guard">
              <p>©<?=date('Y')?> Все права защищены</p>
            </div>
            <div class="col-lg-9">
              <div class="row text-lg-right">
                <div class="col-lg-5"><span><?=$about_company->address?></span></div>
                <div class="col-lg-3"><a href="#" class="info-ftr"><?=$about_company->mail?></a></div>
                <div class="col-lg-4"><a href="tel:<?=$about_company->phone?>" class="number-ftr"><?=$about_company->phone?></a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>