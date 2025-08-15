<?php

namespace App\Parser\Test\Unit\Entity;

use App\Parser\Entity\Parser\Course;
use PHPUnit\Framework\TestCase;

class CourseTest extends TestCase
{
    public function testSuccess(): void
    {
        $course = new Course($id = '26020', $ticketId = '2cf27a8d06f64bdcbe15237c1053e231');
        $this->assertEquals($id, $course->getId());
        $this->assertEquals($ticketId, $course->getTicketId());
    }

    public function testEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Course('', '');
    }
}
