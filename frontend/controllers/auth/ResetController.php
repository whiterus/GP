<?php

namespace frontend\controllers\auth;


use shop\forms\auth\PasswordResetRequestForm;
use shop\forms\auth\ResetPasswordForm;
use shop\services\auth\PasswordResetService;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class ResetController extends Controller
{
    private $passwordResetService;

    public function __construct(
        $id,
        $module,
        PasswordResetService $passwordResetService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->passwordResetService = $passwordResetService;
    }



    public function actionRequest()
    {

        $form = new PasswordResetRequestForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->passwordResetService->request($form);
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('request', [
            'model' => $form,
        ]);

    }


    public function actionConfirm($token)
    {
        try{
            $this->passwordResetService->validateToken($token);
        } catch (\DomainException $e){
            throw new BadRequestHttpException($e->getMessage());
        }

        $form = new ResetPasswordForm();
        if ( $form->load(Yii::$app->request->post()) &&  $form->validate()) {
            try{

                $this->passwordResetService->reset($token, $form);
                Yii::$app->session->setFlash('succeess', 'New password saved.');
                return $this->goHome();
            } catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('confirm', [
            'model' =>  $form,
        ]);
    }


}