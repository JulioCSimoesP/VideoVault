<?php

namespace juliocsimoesp\PHPMVC1\Controller;

use DomainException;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\RedirectionManager;

class DeleteVideoController extends Controller implements RequestController
{

    public function processRequest(): void
    {
        if (!isset($_GET['id'])) {
            RedirectionManager::redirect();
        }

        try {

            if ($this->videoRepository->removeVideo($_GET['id'])) {
                RedirectionManager::redirect(RedirectionManager::DEFAULT_DESTINATION, ['sucesso' => 1]);
            } else {
                RedirectionManager::redirect(RedirectionManager::DEFAULT_DESTINATION, ['sucesso' => 0]);
            }

        } catch (DomainException $exception) {

            RedirectionManager::redirect(RedirectionManager::DEFAULT_DESTINATION, ['erro' => 1]);

        }
    }
}