<?php

namespace App\Frontend;

use Webmozart\Assert\Assert;

class FrontendUrlGenerator
{
    public function __construct(private readonly string $baseUrl)
    {
        Assert::notEmpty($baseUrl);
    }

    public function generate(string $url, array $params = []): string
    {
        return $this->baseUrl .
            (!empty($url) ? '/' . ltrim($url, '/')  : '') .
            (!empty($params) ? '?' . http_build_query($params) : '');
    }
}
