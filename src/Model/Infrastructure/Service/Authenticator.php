<?php

namespace juliocsimoesp\PHPMVC1\Model\Infrastructure\Service;

use juliocsimoesp\PHPMVC1\Model\Domain\Entity\User;

class Authenticator
{

    public static function authenticate(User|null $user, string $insertedPassword): bool
    {
        $storedPassword = password_hash(' ', PASSWORD_ARGON2ID);
        if ($user) {
            $storedPassword = $user->password;
        }

        return password_verify($insertedPassword, $storedPassword) && !is_null($user);
    }
}