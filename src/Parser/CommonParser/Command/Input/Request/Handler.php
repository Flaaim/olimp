<?php

namespace App\Parser\CommonParser\Command\Input\Request;

use App\Parser\CommonParser\Command\ParserCommand;
use App\Parser\Entity\Parser\CommonParser\Course;
use App\Parser\Entity\Parser\CommonParser\Host;
use App\Parser\Entity\Parser\CommonParser\Parser;
use App\Parser\Entity\Parser\Cookie;
use App\Parser\Entity\Parser\HostMapper;
use App\Shared\Domain\ValueObject\Id;
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
