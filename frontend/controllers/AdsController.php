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
use common\models\Favorites;
use common\models\Category;
use backend\models\Subcategory;
use common\models\Regions;
use yii\widgets\ActiveForm;
use backend\models\Promotions;
use common\models\Users;
use common\models\HistoryOperations;
use yii\web\UploadedFile;
use \yii\web\Response;
use common\models\Districts;

class AdsController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if( $action->id == 'create' || $action->id == 'edit' || $action->id == 'status' || 
            $action->id == 'premium' ||  $action->id == 'delete-form' || 
            $action->id == 'delete' || $action->id == 'catalog' || $action->id == 'remove-img') {
            if (Yii::$app->user->isGuest) { 
                throw new HttpException(403,'У вас нет разрешения на доступ к этому действию.');
            }
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $identity = Yii::$app->user->identity;
        $model = new Ads();
        $model->user_id = $identity->id;


        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load($request->post()) && $model->validate() && $model->save()) {
            if(isset($request->post()['add_catalog'])) {
                $catalog = new UsersCatalog();
                $catalog->user_id = $identity->id;
                $catalog->ads_id = $model->id;
                $catalog->save();
            }
            // $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            // if ($model->uploads()) {
            //     // file is uploaded successfully
            //     //return;
            // }
            $model->UploadImage($_POST);

            return $this->redirect(['/ads/view?id=' . $model->id]);
        }

        return $this->render('_form',[
            'catalog' => null,
            'model' => $model,
            'post' => $_POST,
            'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionEdit($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $catalog = UsersCatalog::find()->where(['ads_id' => $model->id])->one();
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load($request->post()) && $model->validate() && $model->save()) {
            
            $model->UploadImage($_POST);
            if(isset($request->post()['add_catalog'])) {
                if($catalog == null) {
                    $catalog = new UsersCatalog();
                    $catalog->user_id = $identity->id;
                    $catalog->ads_id = $model->id;
                    $catalog->save();
                }
            } else {
                if($catalog != null) {
                    $catalog->delete();
                }
            }

            return $this->redirect(['/ads/view?id=' . $model->id]);
        }

        return $this->render('_form',[
            'catalog' => $catalog,
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
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $promotions = $model->getPromotionList();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($request->post()) {
            if(isset($request->post()['promotion'])) {
                $promotion = Promotions::findOne($request->post()['promotion']);
                if($promotion->premium == 1) {
                    $model->premium = 1;
                    $model->premium_date = date('Y-m-d', strtotime(date('Y-m-d'). ' + ' . $promotion->days . ' days') );
                }
                if($promotion->top == 1) {
                    $model->top = 1;
                    $model->top_date = date('Y-m-d', strtotime(date('Y-m-d'). ' + ' . $promotion->days . ' days') );
                }
                $user = Users::findOne(Yii::$app->user->identity->id);
                $user->balance = $user->balance - $promotion->price;
                $user->save(false);
                $model->save(false);

                $history = new HistoryOperations();
                $history->type = 2;
                $history->field_id = "" . $promotion->id;
                $history->summa = $promotion->price;
                $history->save();
            }

            return $this->redirect(['/profile']);
        }
        else {
            $status = 0;
            foreach ($promotions as $value) {
                if($value['status'] == 3) $status++;
            }
            return $this->renderAjax('_premium_form', [
                'model' => $model,
                'status' => $status,
                'promotions' => $promotions,
                'nowLanguage' => Yii::$app->language,
            ]);
        }
    }

    // rasmlarni yuklash uchun
    public function actionSaveImg()
    {
        $images = [];
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/ads_trash/';

        for ($i = 0; $i < count($_FILES['file']['name']); $i++) {

        $ext = "";
        $ext = substr(strrchr($_FILES['file']['name'][$i], "."), 1); 

        $fPath = $_POST['names'][$i];
            if($ext != ""){
               $images []= $fPath;
               $result = move_uploaded_file($_FILES['file']['tmp_name'][$i], $uploadDir . $fPath);
            }
        }
    }

    public function actionRemoveImg($id, $path)
    {
        $model = $this->findModel($id);
        $array = explode(',', $model->images);
        $result = "";
        foreach ($array as $value) {
            if($path != $value) {
                if($result == "") $result = $value;
                else $result .= ',' . $value;
            }
        }
        $model->images = $result;
        $model->save();
        return 1;
    }

    // yuklangan rasmni xotiradan o'chirish uchun
    public function actionDeleteImage($value,$id)
    {
        if($id)
        {
            $model = $this->findModel($id);
            $model->images = Ads::unlinkFile($value,$model->images);
            $model->save(false);
        }else{
            echo "kemadi id";
            Ads::unlinkFile($value);
        }
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
    	$model = $this->findModelToAll($id);
    	$identity = Yii::$app->user->identity;
        $favorites = Favorites::find()->where(['type' => 1])->all();

        $likedAds = Ads::find()
            ->joinWith(['category', 'user', 'currency', 'subcategory'])
            ->where(['like', 'subcategory.name', $model->subcategory->name])
            ->orderBy(['rand()' => SORT_DESC])
            ->all();

        if($identity != null) {
            if($model->user_id == $identity->id) $path = '/profile';
            else $path = '/profile/user?id=' . $model->user_id;
        }
        else $path = '/profile/user?id=' . $model->user_id;

        return $this->render('view',[
        	'identity' => $identity,
            'model' => $model,
            'path' => $path,
            'likedAds' => $likedAds,
            'favorites' => $favorites,
        	'nowLanguage' => Yii::$app->language,
        ]);
    }

    public function actionSubcategory($id)
    {
        $subcategory = Subcategory::find()->where(['category_id' => $id])->all();
        foreach ($subcategory as $value) { 
            echo "<option value = '".$value->id."'>".$value->name."</option>" ;            
        }
    }

    public function actionDistricts($id)
    {
        $dis = Districts::find()->where(['region_id' => $id])->all();
        foreach ($dis as $value) { 
            echo "<option value = '".$value->id."'>".$value->name."</option>" ;            
        }
    }

    protected function findModel($id)
    {
        if (($model = Ads::find()->where(['ads.id' => $id])->one()) !== null) {
            $identity = Yii::$app->user->identity;
            if($model->user_id != $identity->id) {
                throw new HttpException(403, 'У вас нет разрешения на доступ к этому действию.');
            }
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelToAll($id)
    {
        if (($model = Ads::find()->joinWith(['region', 'district', 'user', 'currency', 'subcategory'])->where(['ads.id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}