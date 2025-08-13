<?php

namespace App\Parser\Command\Input\Request;

use App\Parser\Command\Input\Response\Response;
use App\Parser\Entity\Cookie;
use App\Parser\Entity\Course;
use App\Parser\Entity\Host;
use App\Parser\Entity\Id;
use App\Parser\Entity\Parser;
use Ramsey\Uuid\Uuid;

class Handler
{
    public function handle(Command $command): Response
    {
        $parser = new Parser(
            new Id(Uuid::uuid4()->toString()),
            new Host($command->host),
            new Course($command->branchId, $command->ticketId),
            new Cookie($command->cookie),
        );


        return new Response($parser);
    }
}
