<?php

namespace App\Parser\Command\Input\Request;

use App\Parser\Command\ParserCommand;
use App\Parser\Entity\Parser\Cookie;
use App\Parser\Entity\Parser\Course;
use App\Parser\Entity\Parser\Host;
use App\Parser\Entity\Parser\HostMapper;
use App\Parser\Entity\Parser\Id;
use App\Parser\Entity\Parser\Parser;
use Ramsey\Uuid\Uuid;

class Handler
{
    public function __construct(private readonly HostMapper $hostMapper)
    {}
    public function handle(ParserCommand $command): Parser
    {
        return new Parser(
            new Id(Uuid::uuid4()->toString()),
            new Host($command->host, $this->hostMapper),
            new Course($command->branchId, $command->ticketId),
            new Cookie($command->cookie),
        );
    }

}
