<?php

namespace juliocsimoesp\PHPMVC1\Controller;

use DomainException;
use Firebase\JWT\SignatureInvalidException;
use InvalidArgumentException;
use juliocsimoesp\PHPMVC1\Model\Domain\Entity\Video;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\JWTHandler;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Service\UploadManager;
use UnexpectedValueException;

class APINewVideoController extends Controller implements RequestController
{

    public function processRequest(): void
    {
        if(!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            http_response_code(401);
            exit();
        }

        try {
            $tokenData = JWTHandler::decodeJWTToken($_SERVER['HTTP_AUTHORIZATION']);
        } catch (InvalidArgumentException | DomainException | UnexpectedValueException | SignatureInvalidException) {
            http_response_code(401);
            exit();
        }

        $requestPayload = file_get_contents("php://input");
        $inputData = json_decode($requestPayload, true);

        if ($inputData === null || !isset($inputData['url']) || !isset($inputData['title'])) {
            http_response_code(400);
            exit();
        }

        try {

            $video = new Video(
                $inputData['url'],
                $inputData['title']
            );

            UploadManager::processBase64ImageUpload($video, $inputData['image'] ?? null);
            $operationSuccess = $this->videoRepository->addVideo($video);

            if (!$operationSuccess) {
                http_response_code(500);
                exit();
            }

            http_response_code(201);

        } catch (InvalidArgumentException | DomainException $exception) {

            http_response_code(400);
            exit();

        }
    }
}