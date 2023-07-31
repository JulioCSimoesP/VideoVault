<?php

namespace juliocsimoesp\PHPMVC1\Controller;

class Error404Controller implements RequestController
{

    public function processRequest(): void
    {
        http_response_code(404);
    }
}