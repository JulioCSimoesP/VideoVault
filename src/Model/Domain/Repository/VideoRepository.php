<?php

namespace juliocsimoesp\PHPMVC1\Model\Domain\Repository;

use juliocsimoesp\PHPMVC1\Model\Domain\Entity\Video;

interface VideoRepository
{
    public function addVideo(Video $video):bool;

    public function deleteVideo(int $id):bool;

    public function updateVideoAll(Video $video):bool;

    /**
     * @return Video[]
     */
    public function allVideos(): array;

    public function videoById(int $id): Video;
}