<?php

namespace juliocsimoesp\PHPMVC1\Controller;

use DomainException;
use InvalidArgumentException;
use juliocsimoesp\PHPMVC1\Model\Domain\Entity\Video;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\RedirectionManager;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\UploadManager;

class UpdateVideoController extends Controller implements RequestController
{

    public function processRequest(): void
    {
        if (!isset($_GET['id']) || !isset($_POST['url']) || !isset($_POST['titulo'])) {
            RedirectionManager::redirect();
        }

        try {

            $video = new Video(
                $_POST['url'],
                $_POST['titulo']
            );
            $video->setId($_GET['id']);

            if ($_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $generatedPath = UploadManager::processImageUpload();
                $video->setImagePath($generatedPath);
                $operationSuccess = $this->videoRepository->updateVideoAll($video);
            } else {
                $operationSuccess = $this->videoRepository->updateVideoStandard($video);
            }

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