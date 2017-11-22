<?php
namespace frontend\controllers;

use shop\services\ContactService;
use Yii;
use yii\web\Controller;
use shop\forms\ContactForm;


class SiteController extends Controller
{

    private $contactService;

    public function __construct(
        $id,
        $module,
        ContactService $contactService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->contactService = $contactService;
    }


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



    public function actionIndex()
    {
        return $this->render('index');
    }




    public function actionContact()
    {
        $form = new ContactForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            try{
                $this->contactService->send($form);
                yii::$app->session->setFlash('success', 'Спасибо за заявку, менеджер связется с Вами в ближайшее время.');
            }
            catch(\Exception $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', 'Ошибка, пожалуйста обратитесь с Вашим вопросом по телефону.');
            }
            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $form,
        ]);
    }



    public function actionAbout()
    {
        return $this->render('about');
    }




}
