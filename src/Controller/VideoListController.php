<?php

namespace juliocsimoesp\PHPMVC1\Controller;

class VideoListController extends Controller implements RequestController
{

    public function processRequest(): void
    {
        $videoList = $this->videoRepository->allVideos();

        require_once __DIR__ . './../View/lista-videos.php';
    }
}