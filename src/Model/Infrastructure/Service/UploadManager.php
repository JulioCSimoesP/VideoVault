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

        $generatedPath = self::generatePath();

        if (is_null($generatedPath)) {
            return;
        }

        move_uploaded_file(
            $_FILES['imagem']['tmp_name'],
            __DIR__ . "/../../../../public/img/uploads/" . $generatedPath
        );
        $video->setImagePath($generatedPath);
    }

    private static function generatePath(): string|null
    {
        $safeImageName = uniqid('upload_') . '_' . pathinfo($_FILES['imagem']['name'], PATHINFO_BASENAME);
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($_FILES['imagem']['tmp_name']);

        if (!str_starts_with($mimeType, 'image/')) {
            return null;
        }

        return $safeImageName;
    }
}