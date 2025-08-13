<?php

namespace App\Parser\Entity;

use Webmozart\Assert\Assert;

class Cookie
{
    private array $cookies;
    public function __construct(string $value)
    {

        Assert::notEmpty($value);
        $this->cookies = $this->parseCookieString($value);

        Assert::keyExists($this->cookies, '.OLIMPAUTH');
        Assert::notEmpty($this->cookies['.OLIMPAUTH']);
    }
    private function parseCookieString(string $cookieString): array
    {
        $cookies = [];
        $pairs = explode(';', $cookieString);

        foreach ($pairs as $pair) {
            $pair = trim($pair);
            if($pair === ''){
                continue;
            }

            $parts = explode('=', $pair, 2);
            $key = trim($parts[0]);
            $value = isset($parts[1]) ? trim($parts[1]) : '';

            $cookies[$key] = $value;
        }
        return $cookies;
    }
    public function getCookies(): array
    {
        return $this->cookies;
    }
    public function getCookiesToString(): string
    {
        $result = [];
        foreach ($this->cookies as $key => $value) {
            $result[] = $key . '=' . $value;
        }
        return implode('; ', $result);
    }
}
