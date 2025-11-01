<?php

namespace Test\Functional;

class NotFoundTest extends WebTestCase
{
    public function testNotFound(): void
    {
        $response = $this->app()->handle(self::json('GET', '/asd'));

        $this->assertSame(404, $response->getStatusCode());
        self::assertJson((string)$response->getBody());

    }
}
