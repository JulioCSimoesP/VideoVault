<?php

namespace juliocsimoesp\PHPMVC1\Model\Infrastructure\Exception;

class DestroyedSessionAccessException extends \Exception
{
    private string|null $remoteAddress;
    private string|null $httpForwarded;
    private int $timeStamp;

    public function __construct(string|null $remoteAddress, string|null $httpForwarded, int $timeStamp)
    {
        $this->remoteAddress = $remoteAddress;
        $this->httpForwarded = $httpForwarded;
        $this->timeStamp = $timeStamp;

        $message = 'Conexão instável. Por favor tente conectar novamente.';
        parent::__construct($message);
    }
}