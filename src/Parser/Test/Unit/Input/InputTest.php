<?php

namespace App\Parser\Test\Unit\Input;

use App\Parser\Entity\Cookie;
use App\Parser\Entity\Course;
use App\Parser\Entity\Host;
use App\Parser\Entity\Id;
use App\Parser\Entity\Parser;
use PHPUnit\Framework\TestCase;


class InputTest extends TestCase
{
    public function testParserInput(): void
    {
        $parser = new Parser(
            $id = Id::generate(),
            $host = Host::chukk(),
            $course = new Course('26020', '2cf27a8d06f64bdcbe15237c1053e231'),
            $cookie = new Cookie('.OLIMPAUTH=4D8kz0uQ8iPzdfkqDjDMJsX0zODz5r5RJusj5xnHnjHbTW3El16wPw7/o2ApG8XDiVjpRNxwHsMK10zf/nRRfJ+msMMhkFcVB5W4F+RPcvpF3VmabcOJR41cI/QPLTh0; .OLIMPROLES=; WorkplaceToken=88cfd9d6-9e26-41c3-8e88-52541847e6a9; i18next=ru-RU'),
        );

        $this->assertEquals($id, $parser->getId());
        $this->assertEquals($host, $parser->getHost());
        $this->assertEquals($course, $parser->getCourse());
        $this->assertEquals($cookie, $parser->getCookie());
    }
}
