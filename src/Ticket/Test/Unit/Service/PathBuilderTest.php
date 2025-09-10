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
        foreach ($questions as $question) {
            $builder->forQuestion($question)->create();
            $this->assertDirectoryExists($expectedPath . DIRECTORY_SEPARATOR . $question);
        }
    }

    public function testBuildNestedPathToAnswer(): void
    {
        $builder = (new PathBuilder(sys_get_temp_dir()))
            ->forTicket('1234');
        $builder->create();

        $questions = [
            [
                'id' => '1',
                'answers' => [
                    ['id' => '4'],
                    ['id' => '5'],
                ]
            ],
            [
                'id' => '2',
                'answers' => [
                    ['id' => '7'],
                    ['id' => '8'],
                ]
            ]
        ];
        foreach ($questions as $question) {
            $builder->forQuestion($question['id'])->create();
            $expectedPath = '/tmp/1234' . DIRECTORY_SEPARATOR . $question['id'];
            $this->assertDirectoryExists($expectedPath);
                foreach ($question['answers'] as $answer) {
                    $builder->forAnswer($answer['id'])->create();
                    $expectedPath = '/tmp/1234/'. $question['id'] .'/'. $answer['id'];
                    $this->assertDirectoryExists($expectedPath);
                }
        }

    }
    public function testGetPath(): void
    {
        $builder = (new PathBuilder(sys_get_temp_dir()))->forTicket('1234');

        $this->assertEquals('/tmp/1234/image.jpg', $builder->getImagePath('image.jpg'));
        $this->assertEquals('/tmp/1234/image.jpg', $builder->getImagePath('/image.jpg'));
    }
}
