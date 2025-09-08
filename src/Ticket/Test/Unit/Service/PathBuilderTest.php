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

    public function testGetPath(): void
    {
        $builder = (new PathBuilder(sys_get_temp_dir()))->forTicket('1234');

        $this->assertEquals('/tmp/1234', $builder->getPath());
        $this->assertEquals('/tmp/1234/image.jpg', $builder->getImagePath('image.jpg'));
        $this->assertEquals('/tmp/1234/image.jpg', $builder->getImagePath('/image.jpg'));
    }
    public function testGetImagePathEmpty(): void
    {
        $builder = (new PathBuilder(sys_get_temp_dir()))->forTicket('1234');
        $this->expectException(\InvalidArgumentException::class);
        $builder->getImagePath('');
    }
}
