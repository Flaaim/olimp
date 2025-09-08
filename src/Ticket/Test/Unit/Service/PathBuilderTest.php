<?php

namespace App\Ticket\Test\Unit\Service;

use App\Ticket\Service\ImageDownloader\PathBuilder;
use PHPUnit\Framework\TestCase;


class PathBuilderTest extends TestCase
{
    public function testBuildPathToTicket(): void
    {
        $builder = (new PathBuilder(sys_get_temp_dir()))->forTicket('1234');

        $this->assertEquals('/tmp/1234', $builder->getPath());
    }
}
