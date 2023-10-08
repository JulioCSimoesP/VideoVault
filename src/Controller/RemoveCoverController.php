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
            RedirectionManager::redirect(responseCode: 400);
        }

        try {

            $video = $this->videoRepository->videoById($_GET['id']);
            unlink(__DIR__ . '/../../public/img/uploads/' . $video->imagePath);
            $operationSuccess = $this->videoRepository->removeCover($_GET['id']);

            if ($operationSuccess) {
                RedirectionManager::redirect(responseCode: 303, params: ['sucesso' => 1]);
            } else {
                RedirectionManager::redirect(responseCode: 500);
            }

        } catch (InvalidArgumentException | DomainException $exception) {

            RedirectionManager::redirect(responseCode: 400);

        }
    }
}