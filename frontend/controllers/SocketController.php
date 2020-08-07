<?php

namespace frontend\controllers;

use frontend\models\ChatHandler;
use common\models\Ads;

class SocketController extends \yii\web\Controller
{
    public function actionClearTrash()
    {
    	$trash = Yii::getAlias('@backend/web/uploads/ads_trash/');
    	$files = glob($trash . '*'); //get all file names
		foreach($files as $file){
		    if(is_file($file))
		    unlink($file); //delete file
		}
    }

    public function actionSetPromotion()
    {
    	$ads = Ads::find()->all();
    	foreach ($ads as $value) {
    		if($value->top == 1 && strtotime(date('Y-m-d')) > strtotime($value->top_date)) {
    			$value->top = 0;
    			$value->save(false);
    		}
    		if($value->premium == 1 && strtotime(date('Y-m-d')) > strtotime($value->premium_date)) {
    			$value->premium = 0;
    			$value->save(false);
    		}
    	}
    }
}
