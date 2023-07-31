<?php

namespace juliocsimoesp\PHPMVC1\Model\Domain\Entity;

use DomainException;
use InvalidArgumentException;

class Video
{
    public readonly int $id;
    public readonly string $url;
    public readonly string $title;

    /**
     * @param string $url
     * @param string $title
     */
    public function __construct(string $url, string $title)
    {
        $this->filterUrl($url);
        $this->filterTitle($title);

        $this->url = $url;
        $this->title = $title;
    }

    private function filterUrl(string $url): void
    {
        $url = filter_var($url, FILTER_SANITIZE_URL);

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('URL inválida.');
        }
    }

    private function filterTitle(string $title): void
    {
        $title = filter_var($title);

        if (strlen($title) > 255) {
            throw new DomainException('Título excede limite de caracteres.');
        }

        if (strlen($title) == 0) {
            throw new DomainException('Título vazio.');
        }
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}