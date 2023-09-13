<?php

namespace juliocsimoesp\PHPMVC1\Controller;

use juliocsimoesp\PHPMVC1\Model\Infrastructure\Repository\PdoUserRepository;
use juliocsimoesp\PHPMVC1\Model\Infrastructure\Repository\PdoVideoRepository;

abstract class Controller
{
    protected PdoVideoRepository $videoRepository;
    protected PdoUserRepository $userRepository;

    public function __construct(PdoVideoRepository $videoRepository, PdoUserRepository $userRepository)
    {
        $this->videoRepository = $videoRepository;
        $this->userRepository= $userRepository;
    }
}