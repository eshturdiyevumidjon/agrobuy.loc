<?php

namespace backend\controllers;

use Yii;
use backend\models\Settings;
use backend\models\Translates;
use backend\models\SettingsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use backend\models\Lang;
use yii\helpers\Html;

/**
 * SettingsController implements the CRUD actions for Settings model.
 */
class SettingsController extends Controller
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
     * Lists all Settings models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new SettingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Settings model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        $translations = Translates::find()->where(['table_name'=>$model->tableName(),'field_id'=>$model->id])->all();
        foreach ($translations as $key => $value) {
            switch ($value->field_name) {
                case 'name':
                    $translation_name[$value->language_code] = $value->field_value;
                    break;
                default:
                    $translation_value[$value->language_code] = $value->field_value;
                    break;
            }
        }
        // echo "<pre>";
        // print_r($translation_name);
        // echo "</pre>";
        // die;
        if($request->isAjax){
            
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                    'title'=> Yii::t('app','Settings'),
                    'size'=>'large',
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'names'=>$translation_name,
                        'values'=>$translation_value,
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::t('app','Edit'),['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
                'names'=>$translation_name,
                'values'=>$translation_value,
            ]);
        }
    }

    /**
     * Creates a new Settings model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Settings();  
        $langs = Lang::getLanguages();
        if ($model->load($request->post())) {
            $attr = Settings::NeedTranslation();
            foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'kr')
                    {
                        if(!$model->save())
                            return $this->render('create', [
                                'model' => $model,
                            ]);
                        else continue;
                    }
                foreach ($attr as $key=>$value) {
                   $t=new Translates();
                   $t->table_name=$model->tableName();
                   $t->field_id=$model->id;
                   $t->field_name=$key;
                   $t->field_value=$post["Settings"][$value][$l];
                   $t->field_description=$value;
                   $t->language_code=$l;
                   $t->save();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
       
    }

    /**
     * Updates an existing Settings model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $post=$request->post();
        $langs = Lang::getLanguages();
        $model = $this->findModel($id); 
        $translations = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id])->all();
        foreach ($translations as $key => $value) {
           switch ($value->field_name) {
                case 'name':
                    $translation_name[$value->language_code] = $value->field_value;
                    break;
                default:
                    $translation_value[$value->language_code] = $value->field_value;
                    break;
            }                
        }

            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                $attr = Settings::NeedTranslation();
                
                foreach ($langs as $lang) {
                        $l = $lang->url;
                        if($l == 'kr')
                        {
                           continue;
                        }
                        foreach ($attr as $key=>$value) {
                          $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id,'language_code' => $l,'field_name'=>$key]);
                          if($t->count() == 1){
                             $tt = $t->one();
                             $tt->field_value=$post["Settings"][$value][$l];
                             $tt->save();
                           }
                           else{
                               $tt=new Translates();
                               $tt->table_name=$model->tableName();
                               $tt->field_id=$model->id;
                               $tt->field_name=$key;
                               $tt->field_value=$post["Settings"][$value][$l];
                               $tt->field_description=$value;
                               $tt->language_code=$l;
                               $tt->save();
                           }
                      }
                }

                $translations=Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id])->all();
                foreach ($translations as $key => $value) {
                    switch ($value->field_name) {
                        case 'name':
                            $translation_name[$value->language_code] = $value->field_value;
                            break;
                        default:
                            $translation_value[$value->language_code] = $value->field_value;
                            break;
                    }
                }
                return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'names'=>$translation_name,
                    'values'=>$translation_value,
                ]);
            }
    }

    /**
     * Finds the Settings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Settings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Settings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCkeditor_image_upload()
    {       
        $funcNum = $_REQUEST['CKEditorFuncNum'];

        if($_FILES['upload']) {

          if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name']))) {
          $message = Yii::t('app', "Please Upload an image.");
          }

          else if ($_FILES['upload']["size"] == 0 OR $_FILES['upload']["size"] > 5*1024*1024)
          {
          $message = Yii::t('app', "The image should not exceed 5MB.");
          }

          else if ( ($_FILES['upload']["type"] != "image/jpg") 
                    AND ($_FILES['upload']["type"] != "image/jpeg") 
                    AND ($_FILES['upload']["type"] != "image/png"))
          {
          $message = Yii::t('app', "The image type should be JPG , JPEG Or PNG.");
          }

          else if (!is_uploaded_file($_FILES['upload']["tmp_name"])){

          $message = Yii::t('app', "Upload Error, Please try again.");
          }

          else {
            //you need this (use yii\db\Expression;) for RAND() method 
            //$random = rand(0123456789, 9876543210);
            $random = 1232;

            $extension = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);

            //Rename the image here the way you want
            $name = date("m-d-Y-h-i-s", time())."-".$random.'.'.$extension; 

            // Here is the folder where you will save the images
            $folder = 'uploads/ckeditor_images/';  

            // $url = Yii::$app->urlManager->createAbsoluteUrl($folder.$name);
            $url =  $path = 'https://' . $_SERVER['SERVER_NAME'].'/backend/web/uploads/ckeditor_images/'.$name;
            move_uploaded_file( $_FILES['upload']['tmp_name'], $folder.$name );

          }

          echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'
               .$funcNum.'", "'.$url.'", "'.$message.'" );</script>';

        }


    }
}
