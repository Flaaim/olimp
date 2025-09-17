<?php

namespace App\Frontend\Test;

use App\Frontend\FrontendUrlGenerator;
use PHPUnit\Framework\TestCase;

class FrontendUrlGeneratorTest extends TestCase
{
    public function testSuccess(): void
    {
        $generator = new FrontendUrlGenerator('http://localhost');
        $url = $generator->generate('confirm', ['email' => 'some@email.ru']);

        $expectedUrl = 'http://localhost/confirm?'. http_build_query(['email' => 'some@email.ru']);
        $this->assertEquals($expectedUrl, $url);
    }

    public function testOnlyUrl(): void
    {
        $generator = new FrontendUrlGenerator('http://localhost');
        $url = $generator->generate('confirm');

        $this->assertEquals('http://localhost/confirm', $url);
    }

    public function testEmptyUrl(): void
    {
        $generator = new FrontendUrlGenerator('http://localhost');
        $url = $generator->generate('');

        $this->assertEquals('http://localhost', $url);
    }

    public function testEmptyUrlWithParams(): void
    {
        $generator = new FrontendUrlGenerator('http://localhost');
        $url = $generator->generate('', ['email' => 'test@email.ru']);
        $expectedUrl = 'http://localhost?' . http_build_query(['email' => 'test@email.ru']);
        $this->assertEquals($expectedUrl, $url);
    }
}
