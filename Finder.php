<?php

namespace infoweb\user;

use dektrium\user\Finder as BaseFinder;
use infoweb\user\models\User;

class Finder extends BaseFinder
{   
    /**
     * Finds a user by the given id.
     *
     * @param int $id User id to be used on search.
     *
     * @return models\User
     */
    public function findUserById($id)
    {
        return $this->findUser(['id' => $id, 'scope' => [User::SCOPE_BACKEND, User::SCOPE_BOTH]])->one();
    }

    /**
     * Finds a user by the given username.
     *
     * @param string $username Username to be used on search.
     *
     * @return models\User
     */
    public function findUserByUsername($username)
    {
        return $this->findUser(['username' => $username, 'scope' => [User::SCOPE_BACKEND, User::SCOPE_BOTH]])->one();
    }

    /**
     * Finds a user by the given email.
     *
     * @param string $email Email to be used on search.
     *
     * @return models\User
     */
    public function findUserByEmail($email)
    {
        return $this->findUser(['email' => $email, 'scope' => [User::SCOPE_BACKEND, User::SCOPE_BOTH]])->one();
    }

    /**
     * Finds an account by id.
     *
     * @param int $id
     *
     * @return models\Account|null
     */
    public function findAccountById($id)
    {
        return $this->accountQuery->where(['id' => $id, 'scope' => [User::SCOPE_BACKEND, User::SCOPE_BOTH]])->one();
    }
}
