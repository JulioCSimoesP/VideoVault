<?php

namespace juliocsimoesp\PHPMVC1\Model\Domain\Repository;

use juliocsimoesp\PHPMVC1\Model\Domain\Entity\User;

interface UserRepository
{
    public function createUser(User $user): bool;

    public function userByEmail(string $email): User|null;

    public function updateUserPassword(User $user): bool;
}