<?php

namespace App\Http;

use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;

class HtmlResponse extends Response
{
    public function __construct($data, int $status = 200)
    {
        parent::__construct(
            $status,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($data),
        );
    }
}
