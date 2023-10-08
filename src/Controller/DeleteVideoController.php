<?php

namespace juliocsimoesp\PHPMVC1\Controller;

use DomainException;
use http\Env\Response;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\RedirectionManager;

class DeleteVideoController extends Controller implements RequestController
{

    public function processRequest(): void
    {
        if (!isset($_GET['id'])) {
            RedirectionManager::redirect(responseCode: 400);
        }

        try {

            if ($this->videoRepository->deleteVideo($_GET['id'])) {
                RedirectionManager::redirect(responseCode: 303, params: ['sucesso' => 1]);
            } else {
                RedirectionManager::redirect(responseCode: 303, params: ['erro' => 1]);
            }

        } catch (DomainException $exception) {

            RedirectionManager::redirect(responseCode: 400);

        }
    }
}