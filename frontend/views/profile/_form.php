<section class="edit-page">
    <div class="container">
        <h2 class="title"><?=Yii::t('app', "Profilni tahrirlash")?></h2>

        <?= $this->render('forms/_personal', [
  	        'nowLanguage' => $nowLanguage,
  	        'model' => $model,
  	    ]) ?>

  	    <?= $this->render('forms/_legal_status', [
  	        'nowLanguage' => $nowLanguage,
  	        'model' => $model,
  	    ]) ?>
        
        <?= $this->render('forms/_passport', [
  	        'nowLanguage' => $nowLanguage,
  	        'identity' => $model,
  	    ]) ?>

        <?= $this->render('forms/_inn', [
  	        'nowLanguage' => $nowLanguage,
  	        'model' => $model,
  	    ]) ?>
        
        <?= $this->render('forms/_company', [
  	        'nowLanguage' => $nowLanguage,
  	        'identity' => $model,
  	    ]) ?>
        
        <?= $this->render('reyting', [
  	        'nowLanguage' => $nowLanguage,
  	        'identity' => $model,
  	    ]) ?>
    </div>
</section>