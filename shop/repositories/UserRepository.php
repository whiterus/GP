<?php
namespace shop\repositories;

use shop\entities\User;

class UserRepository
{

    public function findByUsernameOrEmail($value): ?User
    {
        return User::find()->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
    }



}