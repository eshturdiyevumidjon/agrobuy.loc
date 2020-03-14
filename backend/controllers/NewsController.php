<?php

namespace backend\controllers;

use Yii;
use backend\models\News;
use backend\models\NewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use backend\models\Lang;
use yii\web\UploadedFile;
use backend\models\Translates;
use yii\helpers\Html;
use backend\models\NewsSlider;
use backend\models\NewsSort;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
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
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     */
    /*public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            $model = $this->findModel($id);
            Yii::$app->response->format = Response::FORMAT_JSON;
            $translations = Translates::find()->where(['table_name'=>$model->tableName(),'field_id'=>$model->id])->all();
            foreach ($translations as $key => $value) {
                switch ($value->field_name) {
                    case 'title':
                        $translation_title[$value->language_code] = $value->field_value;
                        break;
                    default:
                        $translation_text[$value->language_code] = $value->field_value;
                        break;
                }
            }
            return [
                    'title'=>Yii::t('app','News'),
                    'content'=>$this->renderAjax('view', [
                        'model'=>$model,
                        'titles'=>$translation_title,
                        'texts'=>$translation_text,
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::t('app','Edit'),['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }*/

    /**
     * Creates a new News model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new News();
        $model->data_type = 1;
        $langs = Lang::getLanguages();

        $post = $request->post();
        if($model->load($post)) {
            $attr = News::NeedTranslation();
            foreach ($langs as $lang) {
                $l = $lang->url;
                if($l == 'kr') {
                    if( !$model->save() ) {
                        return $this->render('create', [
                            'model' => $model,
                        ]);
                    }
                    else continue;
                }
                    
                foreach ($attr as $key => $value) {
                    $t = new Translates();
                    $t->table_name = $model->tableName();
                    $t->field_id = $model->id;
                    $t->field_name = $key;
                    $t->field_value = $post["News"][$value][$l];
                    $t->field_description = $value;
                    $t->language_code = $l;
                    $t->save();
                }
            }
                
            $model->imageFiles = UploadedFile::getInstance($model,'imageFiles');
            if(!empty($model->imageFiles)) {
                $name = $model->id . '-' . time();

                $model->imageFiles->saveAs('uploads/news/' . $name . '.' . $model->imageFiles->extension);
                Yii::$app->db->createCommand()
                    ->update('news', 
                    ['image' => $name . '.' . $model->imageFiles->extension], 
                    [ 'id' => $model->id ])
                    ->execute();
            }

            $model->fone_file = UploadedFile::getInstance($model,'fone_file');
            if(!empty($model->fone_file)) {
                if($model->in_photo != null && file_exists('uploads/news/' . $model->in_photo)) {
                    unlink(('uploads/news/' . $model->in_photo));
                }
                $name = $model->id . '-' . time();
                $model->fone_file->saveAs('uploads/news/' . $name.'.'.$model->fone_file->extension);
                Yii::$app->db->createCommand()->update('news', ['in_photo' => $name . '.' . $model->fone_file->extension], [ 'id' => $model->id ])->execute();
            }

            return $this->redirect(['index']);         
        } 
        else {
            return $this->render('create', [
                'model' => $model,
                'sliderProvider' => null,
                'sortProvider' => null,
            ]);
        }       
    }

    /**
     * Updates an existing News model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $post = $request->post();
        $langs = Lang::getLanguages();
        $model = $this->findModel($id);

        $searchSliderModel = new NewsSlider();
        $sliderProvider = $searchSliderModel->search(Yii::$app->request->queryParams, $id);

        $searchSortModel = new NewsSort();
        $sortProvider = $searchSortModel->search(Yii::$app->request->queryParams, $id);

        $translations = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id])->all();
        foreach ($translations as $key => $value) {
            switch ($value->field_name) {
                case 'title':
                    $translation_title[$value->language_code] = $value->field_value;
                    break;
                case 'sort_title':
                    $translation_sort_title[$value->language_code] = $value->field_value;
                    break;
                case 'sort_items':
                    $translation_sort_items[$value->language_code] = $value->field_value;
                    break;
                case 'landing_title':
                    $translation_landing_title[$value->language_code] = $value->field_value;
                    break;
                case 'landing_text':
                    $translation_landing_text[$value->language_code] = $value->field_value;
                    break;
                case 'important':
                    $translation_important[$value->language_code] = $value->field_value;
                    break;
                case 'growing_title':
                    $translation_growing_title[$value->language_code] = $value->field_value;
                    break;
                case 'growing_text':
                    $translation_growing_text[$value->language_code] = $value->field_value;
                    break;
                case 'growing_items':
                    $translation_growing_items[$value->language_code] = $value->field_value;
                    break;
                case 'description':
                    $translation_description[$value->language_code] = $value->field_value;
                    break;
                default:
                    $translation_text[$value->language_code] = $value->field_value;
                    break;
            }                
        }

        if($model->load($request->post()) && $model->validate() && $model->save()) {
            $model->imageFiles = UploadedFile::getInstance($model,'imageFiles');
            if(!empty($model->imageFiles)) {
                if($model->image != null&&file_exists('uploads/news/'.$model->image)) {
                    unlink(('uploads/news/'.$model->image));
                }
                $name = $model->id . '-' . time();
                $model->imageFiles->saveAs('uploads/news/' . $name.'.'.$model->imageFiles->extension);
                Yii::$app->db->createCommand()->update('news', ['image' => $name.'.'.$model->imageFiles->extension], [ 'id' => $model->id ])->execute();
            }

            $model->fone_file = UploadedFile::getInstance($model,'fone_file');
            if(!empty($model->fone_file)) {
                if($model->in_photo != null && file_exists('uploads/news/' . $model->in_photo)) {
                    unlink(('uploads/news/' . $model->in_photo));
                }
                $name = $model->id . '-' . time();
                $model->fone_file->saveAs('uploads/news/' . $name.'.'.$model->fone_file->extension);
                Yii::$app->db->createCommand()->update('news', ['in_photo' => $name . '.' . $model->fone_file->extension], [ 'id' => $model->id ])->execute();
            }
            
            $attr = News::NeedTranslation();
            foreach ($langs as $lang) {
                $l = $lang->url;
                if($l == 'kr') {
                   continue;
                }
                foreach ($attr as $key=>$value) {
                    $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id,'language_code' => $l,'field_name' => $key]);
                    if($t->count() == 1) {
                        $tt = $t->one();
                        $tt->field_value=$post["News"][$value][$l];
                        $tt->save();
                    }
                    else{
                        $tt = new Translates();
                        $tt->table_name = $model->tableName();
                        $tt->field_id = $model->id;
                        $tt->field_name = $key;
                        $tt->field_value = $post["News"][$value][$l];
                        $tt->field_description = $value;
                        $tt->language_code = $l;
                        $tt->save();
                    }
                }
            }
  
            return $this->redirect(['index']);    
        }
        else {
            return $this->render('update', [
                'model' => $model,
                'sliderProvider' => $sliderProvider,
                'sortProvider' => $sortProvider,
                'titles' => $translation_title,
                'texts' => $translation_text,
                'sort_title' => $translation_sort_title,
                'sort_items' => $translation_sort_items,
                'landing_title' => $translation_landing_title,
                'landing_text' => $translation_landing_text,
                'important' => $translation_important,
                'growing_title' => $translation_growing_title,
                'growing_text' => $translation_growing_text,
                'growing_items' => $translation_growing_items,
                'description' => $translation_description,
            ]);
        }
    }

    /**
     * Delete an existing News model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if(file_exists('uploads/news/'.$model->image) && $model->image != null) {
            unlink('uploads/news/'.$model->image);
        }
        Translates::deleteAll(['table_name' => $model->tableName(), 'field_id' => $id]);
        $model->delete();

        if($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            return $this->redirect(['index']);
        }
    }

     /**
     * Delete multiple existing News model.
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
            Translates::deleteAll(['table_name' => $model->tableName(),'field_id' => $id]);
            if(file_exists('uploads/news/'.$model->image)&&$model->image!=null)
            {
                unlink('uploads/news/'.$model->image);
            }
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
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCreateSort($id)
    {
        $request = Yii::$app->request;
        $model = new NewsSort();
        $model->news_id = $id;  

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload'=>'#sort-pjax',
                    'title'=> "Таблица",
                    'forceClose'=>true,
                ];         
            }else{           
                return [
                    'title'=> "Создать",
                    'size' => 'large',
                    'content'=>$this->renderAjax('_sort_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
    }

    public function actionUpdateSort($id)
    {
        $request = Yii::$app->request;
        $model = NewsSort::findOne($id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#sort-pjax',
                    'title'=> "Таблица",
                    'forceClose'=>true,
                ];         
            }else{           
                return [
                    'title'=> "Создать",
                    'size' => 'large',
                    'content'=>$this->renderAjax('_sort_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
    }

    public function actionDeleteSort($id)
    {
        $request = Yii::$app->request;
        $model = NewsSort::findOne($id);
        $model->delete();

        if($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#sort-pjax'];
        }
    }

    public function actionCreateSlider($id)
    {
        $request = Yii::$app->request;
        $model = new NewsSlider();
        $model->news_id = $id;  

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()) {
                $model->imageFiles = UploadedFile::getInstance($model,'imageFiles');
                if(!empty($model->imageFiles)) {
                    if($model->image != null&&file_exists('uploads/news_slider/'.$model->image)) {
                        unlink(('uploads/news_slider/'.$model->image));
                    }
                    $name = $model->id . '-' . time();
                    $model->imageFiles->saveAs('uploads/news_slider/' . $name.'.'.$model->imageFiles->extension);
                    Yii::$app->db->createCommand()->update('news_slider', ['image' => $name.'.'.$model->imageFiles->extension], [ 'id' => $model->id ])->execute();
                }
                return [
                    'forceReload'=>'#slider-pjax',
                    'title'=> "Таблица",
                    'forceClose'=>true,
                ];         
            }else{           
                return [
                    'title'=> "Создать",
                    'size' => 'large',
                    'content'=>$this->renderAjax('_slider_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
    }

    public function actionUpdateSlider($id)
    {
        $request = Yii::$app->request;
        $model = NewsSlider::findOne($id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()) {
                $model->imageFiles = UploadedFile::getInstance($model,'imageFiles');
                if(!empty($model->imageFiles)) {
                    if($model->image != null&&file_exists('uploads/news_slider/'.$model->image)) {
                        unlink(('uploads/news_slider/'.$model->image));
                    }
                    $name = $model->id . '-' . time();
                    $model->imageFiles->saveAs('uploads/news_slider/' . $name.'.'.$model->imageFiles->extension);
                    Yii::$app->db->createCommand()->update('news_slider', ['image' => $name.'.'.$model->imageFiles->extension], [ 'id' => $model->id ])->execute();
                }
                return [
                    'forceReload'=>'#slider-pjax',
                    'title'=> "Таблица",
                    'forceClose'=>true,
                ];         
            }else{           
                return [
                    'title'=> "Создать",
                    'size' => 'large',
                    'content'=>$this->renderAjax('_slider_form', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
    }

    public function actionDeleteSlider($id)
    {
        $request = Yii::$app->request;
        $model = NewsSlider::findOne($id);
        $model->delete();

        if($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#slider-pjax'];
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
