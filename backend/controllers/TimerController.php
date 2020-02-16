<?php

namespace backend\controllers;

use common\models\Ads;

class TimerController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAds()
    {
    	$ads = Ads::find()->all();
    	foreach ($ads as $ad) {
    		if($ad->top_date < date('Y-m-d')) $ad->top = 0;
    		if($ad->premium_date < date('Y-m-d')) $ad->premium = 0;
    		$ad->save(false);
    	}
    }

}
