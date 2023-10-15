<?php

namespace juliocsimoesp\PHPMVC1\Model\Infrastructure\Service;

use finfo;
use juliocsimoesp\PHPMVC1\Model\Domain\Entity\Video;

class UploadManager
{

    public static function processImageUpload(Video $video): void
    {
        if ($_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {
            return;
        }

        $generatedPath = self::generatePath($_FILES['imagem']['tmp_name'], $_FILES['imagem']['name']);

        if (is_null($generatedPath)) {
            return;
        }

        move_uploaded_file(
            $_FILES['imagem']['tmp_name'],
            __DIR__ . "/../../../../public/img/uploads/" . $generatedPath
        );
        $video->setImagePath($generatedPath);
    }

    public static function processBase64ImageUpload(Video $video, string|null $base64Image): void
    {
        if (is_null($base64Image)) {
            return;
        }

        $tempFileName = uniqid();
        $tempFile = sys_get_temp_dir() . '/' . $tempFileName;
        file_put_contents($tempFile, base64_decode($base64Image));
        $imageFilePath = self::generatePath($tempFile, $tempFileName);

        if (is_null($imageFilePath)) {
            return;
        }

        rename($tempFile, __DIR__ . "/../../../../public/img/uploads/" . $imageFilePath);

        $video->setImagePath($imageFilePath);
    }

    private static function generatePath(string $imageFilePath, string $imageFileName): string|null
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($imageFilePath);

        if (!str_starts_with($mimeType, 'image/')) {
            return null;
        }

        $fileNameBody = pathinfo($imageFileName, PATHINFO_FILENAME);
        $fileNameExtension = substr($mimeType, strpos($mimeType, '/') + 1);
        $safeFileName =  $fileNameBody . '.' . $fileNameExtension;

        return uniqid('upload_') . '_' . StringManipulator::slugfyFileName($safeFileName);
    }
}