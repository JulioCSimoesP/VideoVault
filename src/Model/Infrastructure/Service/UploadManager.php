<?php

namespace juliocsimoesp\PHPMVC1\Model\Infrastructure\Service;

class UploadManager
{

    public static function processImageUpload(): string
    {
        move_uploaded_file(
            $_FILES['imagem']['tmp_name'],
            __DIR__ . "/../../../../public/img/uploads/" . $_FILES['imagem']['name']
        );

        return $_FILES['imagem']['name'];
    }
}