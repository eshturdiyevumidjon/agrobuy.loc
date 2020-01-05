<?php

namespace backend\controllers;

use Yii;
use backend\models\Advertisings;
use backend\models\AdvertisingsSearch;
use backend\models\AdvertisingItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use backend\models\AdvertisingItems;
use yii\web\UploadedFile;

/**
 * AdvertisingsController implements the CRUD actions for Advertisings model.
 */
class AdvertisingsController extends Controller
{
    /**
     * @inheritdoc
     */
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
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Advertisings models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new AdvertisingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Advertisings model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;

        $searchModel = new AdvertisingItemsSearch();
        $items = $searchModel->search(Yii::$app->request->queryParams, $id);
            
        return $this->render('view', [
            'model' => $this->findModel($id),
            'items' => $items,
        ]);
    }

    /**
     * Creates a new Advertisings model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateItem($id)
    {
        $request = Yii::$app->request;
        $model = new AdvertisingItems();  
        $model->advertising_id = $id;

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){

                $model->imageFiles = UploadedFile::getInstance($model,'imageFiles');
                if(!empty($model->imageFiles))
                {
                    $name = $model->id . '-' . time();

                    $model->imageFiles->saveAs('uploads/reclama-advert/' . $name.'.'.$model->imageFiles->extension);
                    Yii::$app->db->createCommand()->update('advertising_items', ['file' => $name.'.'.$model->imageFiles->extension], [ 'id' => $model->id ])->execute();
                }

                return [
                    'forceReload'=>'#items-pjax',
                    'title'=> Yii::t('app','Create'),
                    'forceClose'=>true,
                ];         
            }else{           
                return [
                    'title'=> Yii::t('app','Create'),
                    'content'=>$this->renderAjax('_item_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button(Yii::t('app','Save'),['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }
        }else{
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['/advertisings/view', 'id' => $id]);
            } else {
                return $this->render('_item_form', [
                    'model' => $model,
                ]);
            }
        }       
    }

    public function actionUpdateItem($id)
    {
        $request = Yii::$app->request;
        $model = AdvertisingItems::findOne($id);
        $file = $model->file;

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){

                $model->unlinkFile($file);
                $model->upload();
                return [
                    'forceReload'=>'#items-pjax',
                    'title'=> Yii::t('app','Update'),
                    'forceClose'=>true,
                ];         
            }else{           
                return [
                    'title'=> Yii::t('app','Update'),
                    'content'=>$this->renderAjax('_item_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button(Yii::t('app','Save'),['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }
        }else{
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['/advertisings/view', 'id' => $model->advertising_id]);
            } else {
                return $this->render('_item_form', [
                    'model' => $model,
                ]);
            }
        }       
    }

    public function actionDeleteItem($id)
    {
        $request = Yii::$app->request;
        $model = AdvertisingItems::findOne($id);

        $model->unlinkFile($model->file);
        //Translates::deleteAll(['table_name' => $model->tableName(),'field_id' => $id]);
        $model->delete();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#items-pjax'];
        }else{
            return $this->redirect(['index']);
        }
    }

    /**
     * Updates an existing Advertisings model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Advertisings",
                    'forceClose'=>true,
                ];    
            }else{
                 return [
                    'title'=> Yii::t('app','Update'),
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button(Yii::t('app','Save'),['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Advertisings model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing Advertisings model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the Advertisings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Advertisings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Advertisings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
