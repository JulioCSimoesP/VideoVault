<?php

namespace juliocsimoesp\PHPMVC1\Controller;

use juliocsimoesp\PHPMVC1\Model\Infrastructure\Repository\PdoVideoRepository;

abstract class Controller
{
    protected PdoVideoRepository $videoRepository;

    public function __construct(PdoVideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }
}