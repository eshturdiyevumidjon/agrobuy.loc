<?php
namespace backend\controllers;

use Yii;
use yii\base\ErrorException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\RegisterForm;
use backend\models\ResetPassword;
use common\models\Users;
use common\models\Ads;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login','register','reset-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'avtorizatsiya','error','register','reset-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
   public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $lastTime = date('Y-m-d H:i:s', strtotime('-2 minutes', strtotime(date('Y-m-d H:i:s'))));

        $adsCount = Ads::find()->count();
        $userCount = Users::find()->count();
        $onlineUsers = Users::find()->where(['between', 'last_seen', $lastTime, date('Y-m-d H:i:s')])->count();

        return $this->render('index', [
            'adsCount' => $adsCount,
            'userCount' => $userCount,
            'onlineUsers' => $onlineUsers,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();

        if($model->load(Yii::$app->request->post()) && $model->register())
        {

            $login_model = new LoginForm();
            $login_model->username = $model->login;
            $login_model->password = $model->password;
            if ($login_model->login()) {
                return $this->goBack();
            }
            else return $this->redirect(['login']);
        } else {
            return $this->render('register', [
                'model' => $model,
            ]);
        }
    }

    public function actionResetPassword()
    {
        $model = new ResetPassword();
        if ($model->load(Yii::$app->request->post())) {
          
                $user = Users::findOne(['email' => $model->email]);
                $newpassword = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
                $message = Yii::$app->mailer->compose();
                $message->setFrom('itake1110@gmail.com');
                $message->setTo($model->email)
                    ->setSubject('Восстановление пароля')
                    ->setHtmlBody('Уважаемый(ая)' . $user->fio . ' !' . ' Ваш пароль был успешно восстановлен.' . ', ваш пароль:' . $newpassword . '. Для того, чтобы пройти авторизацию, войдите ниже указанному ссылку: ' . 'http://' . $_SERVER['SERVER_NAME'])
                    ->send();
                Yii::$app->db->createCommand()->update('users', ['password' => Yii::$app->security->generatePasswordHash($newpassword)], ['id' => $user->id])->execute();
                Yii::$app->session->setFlash('success','Успешно завершено. Мы отправили информацию на почту');
                return $this->goHome();
           
        }
        else {
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }
        return $this->render('reset-password', [
            'model' => $model,
        ]);
        
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['login']);
    }

    public function actionAvtorizatsiya()
    {
      if(isset(Yii::$app->user->identity->id))
      {
        return $this->render('error');
      }        
       else
        {
            Yii::$app->user->logout();
            $this->redirect(['login']);
        }

    }

    public function actionSetThemeValues()
    {
        $session = Yii::$app->session;
        if (isset($_POST['sd_position'])) $session['sd_position'] = $_POST['sd_position'];

        if (isset($_POST['header_styling'])) $session['header_styling'] = $_POST['header_styling'];

        if (isset($_POST['sd_styling'])) $session['sd_styling'] = $_POST['sd_styling'];

        if (isset($_POST['cn_gradiyent'])) $session['cn_gradiyent'] = $_POST['cn_gradiyent'];

        if (isset($_POST['cn_style'])) $session['cn_style'] = $_POST['cn_style'];

        if (isset($_POST['boxed'])) $session['boxed'] = $_POST['boxed'];

    }

    public function actionSdPosition()
    {
        $session = Yii::$app->session;
        if($session['sd_position'] != null) return $session['sd_position'];
        else return 1;
    }

    public function actionHeaderStyling()
    {
        $session = Yii::$app->session;
        if($session['header_styling'] != null) return $session['header_styling'];
        else return 1;
    } 

    public function actionSdStyling()
    {
        $session = Yii::$app->session;
        if($session['sd_styling'] != null) return $session['sd_styling'];
        else return 1;
    } 

    public function actionCnGradiyent()
    {
        $session = Yii::$app->session;
        if($session['cn_gradiyent'] != null) return $session['cn_gradiyent'];
        else return 1;
    } 

    public function actionCnStyle()
    {
        $session = Yii::$app->session;
        if($session['cn_style'] != null) return $session['cn_style'];
        else return 1;
    } 
    public function actionBoxed()
    {
        $session = Yii::$app->session;
        if($session['boxed'] != null) return $session['boxed'];
        else return 1;
    } 

}

