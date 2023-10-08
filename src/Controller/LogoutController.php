<?php

namespace juliocsimoesp\PHPMVC1\Controller;

use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\RedirectionManager;

class LogoutController extends Controller implements RequestController
{

    public function processRequest(): void
    {
        unset($_SESSION['logado']);
        RedirectionManager::redirect('login', 303);
    }
}