<?php

namespace frontend\controllers;

use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use frontend\models\Sessions;
use backend\models\News;
use common\models\Ads;
use common\models\UsersCatalog;
use yii\filters\VerbFilter;

class AdsController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

	public function actionIndex()
    {
    	$session = new Sessions();
    	$identity = Yii::$app->user->identity;

        return $this->render('index',[
        	'identity' => $identity,
            'history' => $history,
        	'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionEdit($id)
    {
        $model = $this->findModel($id);
        $identity = Yii::$app->user->identity;

        return $this->render('_form',[
            'identity' => $identity,
            'model' => $model,
            'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionStatus($id)
    {
        $model = $this->findModel($id);
        if($model->status == 1) $model->status = 2;
        else $model->status = 1;
        $model->save();

        return $this->redirect(['/profile']);
    }

    public function actionPremium($id)
    {
        $model = $this->findModel($id);
        /*if($model->status == 1) $model->status = 2;
        else $model->status = 1;
        $model->save();*/

        return $this->redirect(['/profile']);
    }

    public function actionDeleteForm($id)
    {
        $model = $this->findModel($id);

        return $this->renderAjax('_delete_form',[
            'model' => $model,
            'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $file = $model->images;
        if($file) $model->unlinkFile($file);
        $model->delete();
        return $this->redirect(['/profile']);
    }

    public function actionCatalog($id)
    {
        $model = $this->findModel($id);
        $catalog = UsersCatalog::find()->where(['ads_id' => $model->id])->one();
        if($catalog == null){
            $catalog = new UsersCatalog();
            $catalog->user_id = $model->user_id;
            $catalog->ads_id = $model->id;
            $catalog->save();
        } else $catalog->delete();

        return $this->redirect(['/profile']);
    }

    public function actionView($id)
    {
    	$news = News::findOne($id);
    	$identity = Yii::$app->user->identity;

        return $this->render('view_other_ads',[
        	'identity' => $identity,
            'news' => $news,
        	'nowLanguage' => Yii::$app->language,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Ads::findOne($id)) !== null) {
            $identity = Yii::$app->user->identity;
            if($model->user_id != $identity->id) {
                throw new HttpException(403, 'У вас нет разрешения на доступ к этому действию.');
            }
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}