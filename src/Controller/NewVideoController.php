<?php

namespace juliocsimoesp\PHPMVC1\Controller;

use DomainException;
use InvalidArgumentException;
use juliocsimoesp\PHPMVC1\Model\Domain\Entity\Video;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\RedirectionManager;

class NewVideoController extends Controller implements RequestController
{

    public function processRequest(): void
    {
        if (!isset($_POST['url']) || !isset($_POST['titulo'])) {
            RedirectionManager::redirect();
        }

        try {

            $video = new Video(
                $_POST['url'],
                $_POST['titulo']
            );

            if ($this->videoRepository->addVideo($video)) {
                RedirectionManager::redirect(RedirectionManager::DEFAULT_DESTINATION, ['sucesso' => 1]);
            } else {
                RedirectionManager::redirect(RedirectionManager::DEFAULT_DESTINATION, ['sucesso' => 0]);
            }

        } catch (InvalidArgumentException | DomainException $exception) {

            RedirectionManager::redirect(RedirectionManager::DEFAULT_DESTINATION, ['erro' => 1]);

        }
    }
}