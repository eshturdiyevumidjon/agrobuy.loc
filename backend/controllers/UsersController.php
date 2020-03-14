<?php

namespace backend\controllers;

use Yii;
use common\models\Users;
use common\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\UploadedFile;
use common\models\AdsSearch;
use common\models\DeletingHistory;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
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
                    //'delete' => ['post'],
                    //'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $promotions = $model->getPromotions();
        $histories = $model->getHistories();
        $assessment = $model->getAssessmentsList();

        $searchModel = new AdsSearch();
        $catalogProvider = $searchModel->searchByCatalog(Yii::$app->request->queryParams, $id);
        $adsProvider = $searchModel->searchByUser(Yii::$app->request->queryParams, $id);
        $favoritesProvider = $searchModel->searchByFavorites(Yii::$app->request->queryParams, $id);

        return $this->render('view', [
            'model' => $model,
            'promotions' => $promotions,
            'catalogProvider' => $catalogProvider,
            'adsProvider' => $adsProvider,
            'histories' => $histories,
            'assessment' => $assessment,
            'favoritesProvider' => $favoritesProvider,
        ]);
    }

    /*public function actionChangeAvatar()
    {
        $path = 'uploads/avatars/';  
        $img = $_POST['name'];
        $tmp = $_FILES['file']['tmp_name'];

        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        if($user->image!=null&&file_exists($path.$img))
        {
            unlink(($path.$img));
        }
        $path = $path. $img; 
        if(move_uploaded_file($tmp,$path)) 
        {
        }
    }*/

    /**
     * Creates a new Users model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionChange($id)
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
                    'forceClose' => true,
                    'forceReload'=>'#profile-pjax',
                ];    
            }else{
                 return [
                    'title'=> "Изменить",
                    'size' => "large",
                    'content'=>$this->renderAjax('change', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-primary pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-info','type'=>"submit"])
                ];        
            }
        }
        else{
            echo "ddd";
        }
    }

    public function actionProfile()
    {
        $request = Yii::$app->request;
        return $this->render('profile', [
        ]);        
    }
    
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Users();  

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                
                return [
                    'forceClose' => true,
                    'forceReload'=>'#crud-datatable-pjax',
                ];    
            }else{
                 return [
                    'title'=> "Создать",
                    'size' => "large",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-primary pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-info','type'=>"submit"])
                ];        
            }
        }
        else{
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } 
            else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing Users model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionChangePersonal($id, $type)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        Yii::$app->response->format = Response::FORMAT_JSON;

        if($model->birthday != null) $model->birthday = date("d.m.Y", strtotime($model->birthday ));
        if($model->passport_date != null) $model->passport_date = date("d.m.Y", strtotime($model->passport_date ));

        if($model->load($request->post()) && $model->save()) {
            $model->image = UploadedFile::getInstance($model, 'image');
            $model->upload();

            $model->passport_image = UploadedFile::getInstance($model, 'passport_image');
            $model->uploadPassport();

            $model->company_image = UploadedFile::getInstance($model, 'company_image');
            $model->uploadCompanyFiles();

            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];    
        }
        else{
            $fileName = ''; $size = 'large';
            if($type == 1) { $fileName = 'forms/personal';
                $size = 'large';
            }
            if($type == 2) { $fileName = 'forms/legal';
                $size = 'normal';
            }
            if($type == 3) { $fileName = 'forms/passport';
                $size = 'normal';
            }
            if($type == 4) { $fileName = 'forms/fiz_yur';
                $size = 'normal';
            }
            if($type == 5) { $fileName = 'forms/request';
                $size = 'normal';
            }
            if($type == 6) { $fileName = 'forms/accesses';
                $size = 'normal';
            }
            return [
                 'title'=> "Изменить пользователя",
                 'size' => $size,
                 'content'=>$this->renderAjax($fileName, [
                     'model' => $model,
                 ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
        }
    }

    public function actionAccess($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if($model->access_comment == null) $model->access_comment = 'Для разрешения данной ситуации обратитесь по номеру (телефон тех поддержки:+000 00 000 00 00)';

        Yii::$app->response->format = Response::FORMAT_JSON;
        if($model->load($request->post()) && $model->validate() && $model->save()) {
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];    
        }
        else{
            return [
                'title'=> "Доступ пользователя",
                'size' => 'normal',
                'content'=>$this->renderAjax('forms/access', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
            ];        
        }
    }

    /**
     * Delete an existing Users model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = new DeletingHistory();

        if($request->isAjax){

            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->validate()) {
                
                if ($id != 1) {
                    $user = Users::findOne($id);
                    if(file_exists('uploads/avatars/' . $user->avatar) && $user->avatar != null) {
                        unlink('uploads/avatars/' . $user->avatar);
                    }
                    $model->about = 'ФИО : ' . $user->fio . ' Телефон : ' . $user->phone . ' Логин : ' . $user->login;
                    $model->save();
                    $user->delete();
                }

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'forceClose'=>true,
                ];    
            } 
            else {
                return [
                    'title'=> Yii::t('app','Delete'),
                    'size' => 'normal',
                    'content'=>$this->renderAjax('forms/_deleting_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button( 'Применить' ,['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }
    }

    public function actionHistory()
    {   
        $request = Yii::$app->request;
        $histories = DeletingHistory::find()->orderBy(['date_cr' => SORT_DESC])->all();

        return $this->render('tabs/deleting', [
            'histories' => $histories,
        ]);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSendFile($file)
    {
        return \Yii::$app->response->sendFile('uploads/avatars/' . $file);
    }

    public function actionDownloadPassport($id)
    {
        $model = $this->findModel($id);
        $dir2 = Yii::getAlias('uploads/users/passports/');
        $zip = new \ZipArchive;
        if(file_exists('download.zip')) unlink(Yii::getAlias('download.zip'));
        $download = 'download.zip';
        $zip->open($download, \ZipArchive::CREATE);
        $images = explode(",", $model->passport_file);
        foreach ($images as $file) {
             if(file_exists($dir2 . $file)) $zip->addFile($dir2 . $file, $file);
        }
        $zip->close();
        header('Content-Type: application/zip');
        header("Content-Disposition: attachment; filename = $download");
        header('Content-Length: ' . filesize($download));
        header("Location: $download");

        \Yii::$app->response->sendFile('download.zip');  
    }
}
