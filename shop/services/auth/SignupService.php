<?php

namespace shop\services\auth;

use shop\forms\auth\SignupForm;
use shop\entities\User;


class SignupService
{
    public function signup(SignupForm $form): User
    {

        $user = User::signup(
            $form->username,
            $form->email,
            $form->password
        );

        if (!$user->save()){
            throw new \DomainException('Saving error.');
        }

        return $user;

    }

}