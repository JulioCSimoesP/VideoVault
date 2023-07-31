<?php

namespace juliocsimoesp\PHPMVC1\Model\Domain\Repository;

use juliocsimoesp\PHPMVC1\Model\Domain\Entity\Video;

interface VideoRepository
{
    public function addVideo(Video $video):bool;

    public function removeVideo(int $id):bool;

    public function updateVideo(Video $video):bool;

    /**
     * @return Video[]
     */
    public function allVideos(): array;

    public function videoById(int $id): Video;
}