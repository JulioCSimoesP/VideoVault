<?php

namespace juliocsimoesp\PHPMVC1\Model\Domain\Entity;

use DomainException;
use InvalidArgumentException;

class Video
{
    public readonly int $id;
    public readonly string $url;
    public readonly string $title;
    public readonly string $imagePath;

    /**
     * @param string $url
     * @param string $title
     */
    public function __construct(string $url, string $title)
    {
        $this->url = $this->filterUrl($url);
        $this->title = $this->filterTitle($title);
    }

    private function filterUrl(string $url): string
    {
        $url = filter_var($url, FILTER_SANITIZE_URL);

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('URL inválida.');
        }

        return $url;
    }

    private function filterTitle(string $title): string
    {
        $title = filter_var($title);

        if (strlen($title) > 255) {
            throw new DomainException('Título excede limite de caracteres.');
        }

        if (strlen($title) == 0) {
            throw new DomainException('Título vazio.');
        }

        return $title;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setImagePath(string $imagePath): void
    {
        $this->imagePath = $this->filterImagePath($imagePath);
    }

    private function filterImagePath(string $imagePath): string
    {
        return filter_var($imagePath);
    }
}