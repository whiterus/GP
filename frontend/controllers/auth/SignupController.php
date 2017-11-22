<?php
namespace frontend\controllers\auth;

use shop\forms\auth\SignupForm;
use shop\services\auth\SignupService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class SignupController extends Controller
{
    private $signupService;

    public function __construct(
        $id,
        $module,
        SignupService $signupService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->signupService = $signupService;
    }


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
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


    public function actionRequest()
    {
        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            try{
                $user = $this->signupService->signup($form);
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
            catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('request', [
            'model' => $form,
        ]);
    }
}