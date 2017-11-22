<?php

namespace shop\services\auth;

use Yii;
use shop\entities\User;
use shop\forms\auth\PasswordResetRequestForm;
use shop\forms\auth\ResetPasswordForm;


class PasswordResetService
{
    public function request(PasswordResetRequestForm $form)
    {
        $user = User::findOne([
            'email' => $form->email,
        ]);

        if (!$user){
            throw new \DomainException('Use not found.');
        }

        $user->requestPasswordReset();

        if (!$user->save()){
            throw new \DomainException('Saving token error.');
        }

        $send = Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();

        if (!$send){
            throw new \DomainException('Sending mail error.');
        }

    }

    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Password reset token cannot be blank.');
        }
        if (!User::findByPasswordResetToken($token)){
            throw new \DomainException('Wrong password reset token.');
        }
    }


    public function reset(string $token, ResetPasswordForm $form): void
    {

        $user = User::findByPasswordResetToken($token);

        if (!$user){
            throw new \DomainException('User not found.');
        }

        $user->resetPassword($form->password);

        if (!$user->save()){
            throw new \RuntimeException('Saving error.');
        }

    }

}