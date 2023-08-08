<?php

namespace juliocsimoesp\PHPMVC1\Model\Domain\Repository;

use juliocsimoesp\PHPMVC1\Model\Domain\Entity\User;

interface UserRepository
{
    public function createUser(User $user): bool;

    public function bringUser(string $email): User;
}