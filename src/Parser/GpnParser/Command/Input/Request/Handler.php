<?php

namespace App\Parser\GpnParser\Command\Input\Request;

use App\Parser\Entity\Parser\Cookie;
use App\Parser\Entity\Parser\GpnParser\Course;
use App\Parser\Entity\Parser\GpnParser\GpnParser;
use App\Parser\Entity\Parser\GpnParser\Host;
use App\Parser\Entity\Parser\HostMapper;
use App\Parser\GpnParser\Command\ParserCommand;
use App\Shared\Domain\ValueObject\Id;
use Ramsey\Uuid\Uuid;

class Handler
{
    public function __construct(private readonly HostMapper $hostMapper)
    {}

    public function handle(ParserCommand $command)
    {
        $course = new Course($command->topicId, $command->materialId, $command->questionIds);
        $host = new Host($command->host, $this->hostMapper);
        $cookie = new Cookie($command->cookie);

        return new GpnParser(
            new Id(Uuid::uuid4()->toString()),
            $course,
            $host,
            $cookie
        );
    }
}
