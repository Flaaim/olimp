<?php

namespace App\Parser\Entity;

use Webmozart\Assert\Assert;

class Cookie
{
    private array $cookies = [];
    public function __construct(string $value)
    {
        $cookies = [];
        Assert::notEmpty($value);
        $pairs = explode(';', $value);
        foreach ($pairs as $pair) {
            $parts = explode('=', $pair, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);
                $cookies[$key] = $value;
            }
        }
        Assert::keyExists($cookies, '.OLIMPAUTH');
        Assert::notEmpty($cookies['.OLIMPAUTH']);
        $this->cookies = $cookies;
    }

    public function getCookies(): array
    {
        return $this->cookies;
    }
    public function getCookiesToString(): string
    {
        return implode(';', $this->cookies);
    }
}
