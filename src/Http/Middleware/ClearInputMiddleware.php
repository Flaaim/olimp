<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ClearInputMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $data = self::filterString($request->getParsedBody());
        return $handler->handle($request->withParsedBody($data));
    }

    private static function filterString($data)
    {
        if(!is_array($data)) {
            return $data;
        }

        $result = [];

        foreach ($data as $key => $value) {
            if(is_string($value)) {
                $result[$key] = trim($value);
            }else{
                $result[$key] = self::filterString($value);
            }
        }

        return $result;
    }
}
