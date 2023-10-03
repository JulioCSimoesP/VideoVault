<?php

namespace juliocsimoesp\PHPMVC1\Controller;

use DomainException;
use InvalidArgumentException;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\RedirectionManager;

class RemoveCoverController extends Controller implements RequestController
{

    public function processRequest(): void
    {
        if (!isset($_GET['id'])) {
            RedirectionManager::redirect();
        }

        try {

            $video = $this->videoRepository->videoById($_GET['id']);
            unlink(__DIR__ . '/../../public/img/uploads/' . $video->imagePath);
            $operationSuccess = $this->videoRepository->removeCover($_GET['id']);

            if ($operationSuccess) {
                RedirectionManager::redirect(RedirectionManager::DEFAULT_DESTINATION, ['sucesso' => 1]);
            } else {
                RedirectionManager::redirect(RedirectionManager::DEFAULT_DESTINATION, ['sucesso' => 0]);
            }

        } catch (InvalidArgumentException | DomainException $exception) {

            RedirectionManager::redirect(RedirectionManager::DEFAULT_DESTINATION, ['erro' => 1]);

        }
    }
}