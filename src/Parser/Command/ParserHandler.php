<?php

namespace App\Parser\Command;

use App\Parser\Command\Input\Request\Handler as InputHandler;

use App\Parser\Command\Parse\Request\Command as ParseCommand;
use App\Parser\Command\Parse\Request\Handler as ParseHandler;


class ParserHandler
{
    private InputHandler $inputHandler;
    private ParseHandler $parseHandler;
    public function __construct(InputHandler $inputHandler, ParseHandler $parseHandler)
    {
        $this->inputHandler = $inputHandler;
        $this->parseHandler = $parseHandler;
    }
    public function handle(ParserCommand $parserCommand): array
    {
        $parser = $this->inputHandler->handle($parserCommand);
        return $this->parseHandler->handle(new ParseCommand($parser));
    }
}
