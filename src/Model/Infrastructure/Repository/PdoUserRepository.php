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
        $statement->bindValue(':password', password_hash($user->password, PASSWORD_ARGON2ID));
        $result =  $statement->execute();

        $user->setId($this->pdo->lastInsertId());

        return $result;
    }

    public function userByEmail(string $email): User|null
    {
        $readQuery = 'SELECT * FROM users WHERE email = :email;';
        $statement = $this->pdo->prepare($readQuery);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $queryResult = $statement->fetch();

        return $this->hydrateUser($queryResult);
    }

    public function updateUserPassword(User $user): bool
    {
        $updateQuery = 'UPDATE users SET password = :password WHERE id = :id;';
        $statement = $this->pdo->prepare($updateQuery);
        $statement->bindValue(':password', password_hash($user->password, PASSWORD_ARGON2ID));
        $statement->bindValue(':id', $user->id, PDO::PARAM_INT);

        return $statement->execute();
    }

    private function verifyClone(User $user): void
    {
        $readQuery = 'SELECT * FROM users WHERE email = :email;';
        $statement = $this->pdo->prepare($readQuery);
        $statement->bindValue(':email', $user->email);
        $statement->execute();

        if ($statement->fetch(PDO::FETCH_ASSOC) !== false) {
            throw new DomainException('Já existe um usuário com este email.');
        }
    }

    private function hydrateUser(array|false $queryResult): User|null
    {
        $user = new User(
            $queryResult['email'] ?? 'email@email.com',
            $queryResult['password'] ?? 'passwordpassword'
        );
        $user->setId($queryResult['id'] ?? '123');

        return $queryResult ? $user : null;
    }
}