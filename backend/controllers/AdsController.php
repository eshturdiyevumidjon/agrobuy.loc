<?php

namespace backend\controllers;

use Yii;
use common\models\Ads;
use common\models\AdsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use \yii\web\Response;
use common\models\Complaints;
use yii\helpers\Html;
use common\models\Chats;
use common\models\ChatUsers;

/**
 * AdsController implements the CRUD actions for Ads model.
 */
class AdsController extends Controller
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
                    // 'delete' => ['post'],
                    // 'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Ads models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new AdsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Ads model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if($model->is_checked == 0) {
            $model->is_checked = 1;
            $model->save(false);
        }

        $searchModel = new Complaints();
        $complaintsProvider = $searchModel->getComplaintsList(Yii::$app->request->queryParams, $id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'complaintsProvider' => $complaintsProvider,
        ]);
    }

    /**
     * Creates a new Ads model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Ads();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                $model->imageFiles = UploadedFile::getInstance($model,'imageFiles');
                if(!empty($model->imageFiles)) $model->upload();
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Объявление",
                    'forceClose'=>true,
                ];         
            }else{           
                return [
                    'title'=> "Создать",
                    'size' => 'large',
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing Ads model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $file = $model->images;

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                $model->imageFiles = UploadedFile::getInstance($model,'imageFiles');
                if(!empty($model->imageFiles))
                {
                    $model->unlinkFile($file);
                    $model->upload();
                }

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Объявление",
                    'forceClose'=>true,
                ];    
            }else{
                 return [
                    'title'=> "Изменить",
                    'size' => 'large',
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
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
     * Delete an existing Ads model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $file = $model->images;
        $model->scenario = Ads::SCENARIO_DELETING;

        if($request->isAjax){

            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->validate()) {
                if($file) {
                    $model->unlinkFile($file);
                }
                $chatUser = ChatUsers::find()
                    ->joinWith('chat')
                    ->where(['chats.type' => 1, 'chat_users.user_id' => $model->user_id])
                    ->one();

                $chatUser->sendMessageAboutDeletingAds($model->comment);
                $model->delete();

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'forceClose'=>true,
                ];    
            } else {
                return [
                    'title'=> Yii::t('app','Delete'),
                    'size' => 'normal',
                    'content'=>$this->renderAjax('delete_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button(Yii::t('app','Delete'),['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }
    }

    /**
     * Finds the Ads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ads::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
