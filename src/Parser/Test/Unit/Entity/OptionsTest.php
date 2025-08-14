<?php

namespace App\Parser\Test\Unit\Entity;

use App\Parser\Entity\Options;
use PHPUnit\Framework\TestCase;
use function DI\value;

class OptionsTest extends TestCase
{
    public function testSuccess(): void
    {
        $array = ['limit' => 5, 'offset' => [1, 5]];
        $options = new Options($array);

        $this->assertSame($options->toArray(), $array);
    }
    public function testGetValue(): void
    {
        $array = ['limit' => 5, 'offset' => [1, 5]];
        $options = new Options($array);

        $this->assertSame($array['limit'], $options->getValue('limit'));
        $this->assertSame($array['offset'], $options->getValue('offset'));

        $this->expectExceptionMessage("Option key does not exist.");
        $options->getValue('count');
    }

    public function testSetValue(): void
    {
        $array = [];
        $newValue = ['limit' => 5];
        $options = (new Options($array))->withValue(key($newValue), current($newValue));

        $this->assertSame($options->getValue('limit'), $newValue['limit']);

        $newValue = ['limit' => 6];

        $options->withValue(key($newValue), current($newValue));

        $this->assertSame($options->getValue('limit'), $newValue['limit']);

    }
}
