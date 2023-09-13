<?php

namespace juliocsimoesp\PHPMVC1\Controller;

use DomainException;
use InvalidArgumentException;
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
            $correctPassword = password_verify($_POST['senha'], $user->password ?? '');

            if (!$correctPassword) {
                RedirectionManager::redirect('login', ['erro' => 1]);
            }

            $_SESSION['logado'] = true;
            RedirectionManager::redirect();

        } catch (InvalidArgumentException | DomainException $exception) {

            RedirectionManager::redirect('login', ['erro' => 1]);

        }
    }
}
