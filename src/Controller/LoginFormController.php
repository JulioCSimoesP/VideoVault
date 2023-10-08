<?php

namespace juliocsimoesp\PHPMVC1\Controller;

use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\RedirectionManager;

class LoginFormController extends Controller implements RequestController
{

    public function processRequest(): void
    {
        if ($_SESSION['logado'] ?? false) {
            RedirectionManager::redirect(responseCode: 303);
        }

        require_once __DIR__ . '/../View/login-form.php';
    }
}