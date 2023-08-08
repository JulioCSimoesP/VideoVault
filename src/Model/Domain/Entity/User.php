<?php

namespace juliocsimoesp\PHPMVC1\Model\Domain\Entity;

use DomainException;
use InvalidArgumentException;

class User
{
    public readonly int $id;
    public readonly string $email;
    public readonly string $password;

    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->filterEmail($email);
        $this->filterPassword($password);

        $this->email = $email;
        $this->password = $password;
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
}