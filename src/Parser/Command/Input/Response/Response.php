<?php

namespace App\Parser\Command\Input\Response;

use App\Parser\Entity\Parser;

class Response
{
    public function __construct(private readonly Parser $parser){}
}
