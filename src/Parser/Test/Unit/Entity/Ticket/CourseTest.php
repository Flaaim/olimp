<?php

namespace App\Parser\Test\Unit\Entity\Ticket;

use App\Parser\Entity\Ticket\Course;
use App\Parser\Entity\Ticket\Part;
use App\Shared\Domain\ValueObject\Id;
use PHPUnit\Framework\TestCase;

class CourseTest extends TestCase
{
    public function testSetPart(): void
    {
        $course = new Course(Id::generate(), 'course', 'course_description');
        $part = new Part(Id::generate(), 'part', 'part_description');

        $course->setPart($part);
        self::assertEquals($course, $part->getCourse());
    }

    public function testUnsetPart(): void
    {
        $course = new Course(Id::generate(), 'course', 'course_description');
        $part = new Part(Id::generate(), 'part', 'part_description');

        $course->setPart($part);
        self::assertEquals($course, $part->getCourse());

        $course->setPart(null);
        self::assertEquals(null, $part->getCourse());
    }
}
