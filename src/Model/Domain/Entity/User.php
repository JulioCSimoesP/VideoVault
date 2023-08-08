<?php

namespace juliocsimoesp\PHPMVC1\Model\Domain\Entity;

use DomainException;
use InvalidArgumentException;

class User
{
    public readonly int $id;
    public readonly string $email;
    private readonly string $password;
    public readonly string $passwordHash;

    /**
     * @param string $email
     * @param string $password
     * @param string|null $passwordHash
     */
    public function __construct(string $email, string $password, string $passwordHash = null)
    {
        $this->filterEmail($email);
        $this->filterPassword($password);

        $this->email = $email;
        $this->password = $password;

        if (is_null($passwordHash)) {
            $this->passwordHash = password_hash($this->password, PASSWORD_ARGON2ID);
        } else {
            $this->passwordHash = $passwordHash;
        }
    }

    private function filterEmail(string $email): void
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email inválido.');
        }
    }

    private function filterPassword(string $password): void
    {
        $password = filter_var($password);

        if (strlen($password) < 8) {
            throw new DomainException('A senha precisa ter pelo menos 8 caracteres.');
        }
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function validatePassword(): bool
    {
        return password_verify($this->password, $this->passwordHash);
    }
}