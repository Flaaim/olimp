<?php

namespace App\Parser\Test\Unit\Entity\Ticket;

use App\Parser\Entity\Ticket\Course;
use App\Parser\Entity\Ticket\Part;
use App\Shared\Domain\ValueObject\Id;
use PHPUnit\Framework\TestCase;

class PartTest extends TestCase
{
    public function testSetCourse(): void
    {
        $part = new Part(Id::generate(), 'part', 'part_description');

        $course = new Course(
            Id::generate(),
            'course',
            'description',
        );

        $part->setCourse($course);
        self::assertEquals($course, $part->getCourse());
    }

}
