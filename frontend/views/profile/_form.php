<section class="edit-page">
    <div class="container">
        <h2 class="title">Редактирование профиля</h2>

        <?= $this->render('_personal', [
  	        'nowLanguage' => $nowLanguage,
  	        'identity' => $identity,
  	    ]) ?>

  	    <?= $this->render('_legal_status', [
  	        'nowLanguage' => $nowLanguage,
  	        'identity' => $identity,
  	    ]) ?>
        
        <?= $this->render('_passport', [
  	        'nowLanguage' => $nowLanguage,
  	        'identity' => $identity,
  	    ]) ?>

        <?= $this->render('_inn', [
  	        'nowLanguage' => $nowLanguage,
  	        'identity' => $identity,
  	    ]) ?>
        
        <?= $this->render('_company', [
  	        'nowLanguage' => $nowLanguage,
  	        'identity' => $identity,
  	    ]) ?>
        
        <?= $this->render('reyting', [
  	        'nowLanguage' => $nowLanguage,
  	        'identity' => $identity,
  	    ]) ?>
    </div>
</section>