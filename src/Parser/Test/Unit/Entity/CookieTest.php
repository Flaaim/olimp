<?php

namespace App\Parser\Test\Unit\Entity;

use App\Parser\Entity\Cookie;
use PHPUnit\Framework\TestCase;

class CookieTest extends TestCase
{
    public function testSuccess(): void
    {
        $value = '.OLIMPAUTH=4D8kz0uQ8iPzdfkqDjDMJsX0zODz5r5RJusj5xnHnjHbTW3El16wPw7/o2ApG8XDiVjpRNxwHsMK10zf/nRRfJ+msMMhkFcVB5W4F+RPcvpF3VmabcOJR41cI/QPLTh0; .OLIMPROLES=; WorkplaceToken=88cfd9d6-9e26-41c3-8e88-52541847e6a9; i18next=ru-RU';

        $cookie = new Cookie($value);

        $this->assertNotEmpty($cookie->getCookies());
        $this->assertIsArray($cookie->getCookies());
        $this->assertEquals($value, $cookie->getCookiesToString());
    }

    public function testEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $cookie = new Cookie('');
    }

    public function testInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Cookie('robin=;Path=/;SameSite=Lax;Expires=Sat, 01 Jan 2000 00:00:01 GMT;Domain=.events-collector-dataplatform.action-media.ru;Secure;

');
    }
}
