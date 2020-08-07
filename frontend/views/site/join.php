<?php

?>

<section class="start-with-us">
    <div class="container">
        <h2 class="title">
           	<?php 
           		$text = explode(' ', Yii::t('app',"Biz bilan boshlang"));
           		$res = '';
           		foreach ($text as $key => $value) {
           			if($key === 0) $res = '<span>' . $value . '</span>';
           			else $res .= ' ' . $value;
           		}
           		echo $res;
           	?>
        </h2>
        <div class="row">
          	<div class="col-3 step-item">
            	<span><?= Yii::t('app',"Qadam") ?> 1</span>
            	<div> <img src="/images/icon-user-plus.png" alt=""> </div>
            	<p><?= Yii::t('app',"Ro'yhatdan o'ting") ?></p>
          	</div>
          	<div class="col-3 step-item">
            	<span><?= Yii::t('app',"Qadam") ?> 3</span>
            	<div> <img src="/images/team.png" alt=""> </div>
            	<p><?= Yii::t('app',"Kompaniyangizni qo'shing") ?></p>
          	</div>
          	<div class="col-3 step-item">
            	<span><?= Yii::t('app',"Qadam") ?> 2</span>
            	<div> <img src="/images/car2.png" alt=""> </div>
            	<p><?= Yii::t('app',"E'loningizni qo'shing") ?></p>
          	</div>
          	<div class="col-3 step-item">
            	<span><?= Yii::t('app',"Qadam") ?> 4</span>
            	<div> <img src='/images/adds.png'> </div>
            	<p><?= Yii::t('app',"Soting") ?></p>
          	</div>
        </div>
    </div>
</section>