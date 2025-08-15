<?php

namespace App\Parser\Test\Unit\Service;

use App\Parser\Service\QuestionDataHandler;
use PHPUnit\Framework\TestCase;

class QuestionDataHandlerTest extends TestCase
{
    public function testClearTags(): void
    {
        $text = 'Как с минимальным риском подняться на крышу здания?';

        $handler = new QuestionDataHandler();
        $clearedText = $handler->stripTagsTextField("<div><div>$text</div></div>");

        $this->assertEquals($text, $clearedText);
    }
}
