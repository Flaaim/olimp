<?php

namespace App\Service\Test\Unit;

use App\Service\TextSanitizer;
use PHPUnit\Framework\TestCase;

class TextSanitizerTest extends TestCase
{
    public function testStripTags(): void
    {
        $sanitizer = new TextSanitizer();
        $cleaned = $sanitizer->cleanTextContent('<div><div>Как с минимальным риском подняться на крышу здания?</div></div>');
        $this->assertSame('Как с минимальным риском подняться на крышу здания?', $cleaned);

        $cleaned = $sanitizer->cleanTextContent('<div><div>Как с минимальным риском подняться на крышу здания?<br></div></div>');
        $this->assertSame('Как с минимальным риском подняться на крышу здания?', $cleaned);

        $cleaned = $sanitizer->cleanTextContent('Как с минимальным риском подняться на крышу здания?');
        $this->assertSame('Как с минимальным риском подняться на крышу здания?', $cleaned);
    }

    public function testStripSpaces(): void
    {
        $sanitizer = new TextSanitizer();
        $cleaned = $sanitizer->cleanTextContent('Как с        минимальным риском          подняться на крышу здания?');

        $this->assertSame('Как с минимальным риском подняться на крышу здания?', $cleaned);

        $cleaned = $sanitizer->cleanTextContent('Как с минимальным
        риском подняться на
        крышу здания?');

        $this->assertSame('Как с минимальным риском подняться на крышу здания?', $cleaned);
    }

    public function testStripHyphens(): void
    {
        $sanitizer = new TextSanitizer();
        $cleaned = $sanitizer->cleanTextContent('-Как с минимальным риском подняться на крышу здания? -');
        $this->assertSame('Как с минимальным риском подняться на крышу здания?', $cleaned);

        $cleaned = $sanitizer->cleanTextContent('- Как с минимальным-риском подняться на крышу здания?-');
        $this->assertSame('Как с минимальным-риском подняться на крышу здания?', $cleaned);
    }
}
