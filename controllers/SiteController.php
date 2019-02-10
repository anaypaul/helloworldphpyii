<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegistrationForm;
use app\models\UploadImageForm;
use yii\web\UploadedFile, models;

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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
        return $this->render('index');
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

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }



    /**
     * Other code
     * to display make hello world page
     */
    public function actionSpeak($message = "Default Message" ){
        return $this->render("speak",['message' => $message]);
    }



    public function actionShowContactModel() { 
        $mContactForm = new \app\models\ContactForm(); 
        $mContactForm->name = "contactForm"; 
        $mContactForm->email = "user@gmail.com"; 
        $mContactForm->subject = "subject"; 
        $mContactForm->body = "body"; 
        var_dump($mContactForm->attributes); 
        return \yii\helpers\Json::encode($mContactForm);
    }


    public function actionRegistration() {
        $mRegistration = new RegistrationForm();
        return $this->render('registration', ['model' => $mRegistration]);
     }

     public function actionUploadImage() {
        $model = new UploadImageForm();
        if (Yii::$app->request->isPost) {
           $model->image = UploadedFile::getInstance($model, 'image');
           if ($model->upload()) {
              // file is uploaded successfully
              echo "File successfully uploaded";
              return;
           }
        }
        return $this->render('upload', ['model' => $model]);
     }
}
