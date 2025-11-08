<?php

namespace App\Parser\Fixture;

use App\Parser\Entity\Ticket\Course;
use App\Shared\Domain\ValueObject\Id;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $course = new Course(
            new Id('1656213f-d7ed-4380-982a-79521717e295'),
            'Оказание первой помощи пострадавшим',
            'Курс Олимпокс для проверки знаний работников по оказанию первой помощи пострадавшим'
        );

        $manager->persist($course);

        $manager->flush();
    }
}
