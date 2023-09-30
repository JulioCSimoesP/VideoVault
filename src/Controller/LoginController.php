<?php

namespace juliocsimoesp\PHPMVC1\Controller;

use DomainException;
use InvalidArgumentException;
use juliocsimoesp\PHPMVC1\Model\Domain\Entity\User;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\Authenticator;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\RedirectionManager;

class LoginController extends Controller implements RequestController
{

    public function processRequest(): void
    {
        if (!isset($_POST['email']) || !isset($_POST['senha'])) {
            RedirectionManager::redirect();
        }

        try {

            $user = $this->userRepository->userByEmail($_POST['email']);
            $correctPassword = Authenticator::Authenticate($user, $_POST['senha']);

            if (!$correctPassword) {
                RedirectionManager::redirect('login', ['erro' => 1]);
            }

            //Trocar por um redirecionamento para controlador de atualização de usuário
            if (password_needs_rehash($user->password, PASSWORD_ARGON2ID) && $correctPassword) {
                $updatedUser = new User($_POST['email'], $_POST['senha']);
                $updatedUser->setId($user->id);
                $this->userRepository->updateUserPassword($updatedUser);
            }

            $_SESSION['logado'] = true;
            RedirectionManager::redirect();

        } catch (InvalidArgumentException | DomainException $exception) {

            RedirectionManager::redirect('login', ['erro' => 1]);

        }
    }
}
