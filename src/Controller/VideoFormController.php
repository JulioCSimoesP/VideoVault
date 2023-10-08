<?php

namespace juliocsimoesp\PHPMVC1\Controller;

use DomainException;
use InvalidArgumentException;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\RedirectionManager;

class VideoFormController extends Controller implements RequestController
{

    public function processRequest(): void
    {
        $video = null;

        if (isset($_GET['id'])) {
            try {

                $video = $this->videoRepository->videoById($_GET['id']);

            } catch (InvalidArgumentException | DomainException $exception) {

                RedirectionManager::redirect(responseCode: 400);

            }
        }

        require_once __DIR__ . './../View/formulario.php';
    }
}