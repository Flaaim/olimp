<?php

namespace App\Parser\Command\Input\Request;

use App\Parser\Command\Input\Response\Response;
use App\Parser\Entity\Course;
use App\Parser\Entity\Host;
use App\Parser\Entity\Id;
use App\Parser\Entity\Parser;
use Ramsey\Uuid\Uuid;

class Handler
{
    public function handle(Command $command): Response
    {
        $host = new Host($command->host);
        $course = new Course($command->branchId, $command->ticketId);

        $parser = new Parser(
            new Id(Uuid::uuid4()->toString()),
            $host,
            $course
        );

        return new Response($parser);
    }
}
