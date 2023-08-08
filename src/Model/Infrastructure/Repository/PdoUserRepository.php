<?php

namespace juliocsimoesp\PHPMVC1\Model\Infrastructure\Repository;

use DomainException;
use juliocsimoesp\PHPMVC1\Model\Domain\Entity\User;
use juliocsimoesp\PHPMVC1\Model\Domain\Repository\UserRepository;
use PDO;

class PdoUserRepository extends PdoRepository implements UserRepository
{

    public function createUser(User $user): bool
    {
        $this->verifyClone($user);

        $insertQuery = 'INSERT INTO users (email, password) VALUES (:email, :password);';
        $statement = $this->pdo->prepare($insertQuery);
        $statement->bindValue(':email', $user->email);
        $statement->bindValue(':password', $user->password);
        $result =  $statement->execute();

        $user->setId($this->pdo->lastInsertId());

        return $result;
    }

    public function userByEmail(string $email): User
    {
        $this->verifyEmail($email);

        $readQuery = 'SELECT * FROM users WHERE email = :email;';
        $statement = $this->pdo->prepare($readQuery);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $queryResult = $statement->fetch();

        return $this->hydrateUser($queryResult);
    }

    private function verifyClone(User $user)
    {
        $readQuery = 'SELECT * FROM users WHERE email = :email;';
        $statement = $this->pdo->prepare($readQuery);
        $statement->bindValue(':email', $user->email);
        $statement->execute();

        if ($statement->fetch(PDO::FETCH_ASSOC) !== false) {
            throw new DomainException('Já existe um usuário com este email.');
        }
    }

    private function verifyEmail(string $email)
    {
        $readQuery = 'SELECT * FROM users WHERE email = :email;';
        $statement = $this->pdo->prepare($readQuery);
        $statement->bindValue(':email', $email);
        $statement->execute();

        if ($statement->fetch(PDO::FETCH_ASSOC) === false) {
            throw new DomainException('Email informado não existe.');
        }
    }

    private function hydrateUser(array $queryResult): User
    {
        $user = new User(
            $queryResult['email'],
            $queryResult['password']
        );
        $user->setId($queryResult['id']);

        return $user;
    }
}