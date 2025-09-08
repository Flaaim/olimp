<?php

namespace App\Ticket\Test\Unit\Service;

use App\Ticket\Service\ImageDownloader\PathBuilder;
use PHPUnit\Framework\TestCase;


class PathBuilderTest extends TestCase
{
    public function testBuildPathToTicket(): void
    {
        (new PathBuilder(sys_get_temp_dir()))
            ->forTicket('1234')
            ->create();

        $this->assertDirectoryExists(sys_get_temp_dir(). DIRECTORY_SEPARATOR . '1234');
    }
    public function testBuildPathToQuestion(): void
    {
        (new PathBuilder(sys_get_temp_dir()))
            ->forQuestion('1234')
            ->create();

        $this->assertDirectoryExists(sys_get_temp_dir() . DIRECTORY_SEPARATOR . '1234');
    }

    public function testBuildNestedPathToQuestion(): void
    {
        $builder = (new PathBuilder(sys_get_temp_dir()))
            ->forTicket('1234');
        $builder->create();

        $questions = ['1', '2'];
        $expectedPath = sys_get_temp_dir(). DIRECTORY_SEPARATOR . '1234';
        foreach ($questions as $key => $question) {
            $builder->forQuestion($question)->create();
            $this->assertDirectoryExists($expectedPath . DIRECTORY_SEPARATOR . $question);
        }
    }
    public function testGetPath(): void
    {
        $builder = (new PathBuilder(sys_get_temp_dir()))->forTicket('1234');

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
