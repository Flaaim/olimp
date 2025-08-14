<?php

namespace App\Parser\Command;

use App\Parser\Command\Input\Request\Handler as InputHandler;
use App\Parser\Command\Process\Request\Command as ProcessCommand;

use App\Parser\Command\Parse\Request\Command as ParseCommand;
use App\Parser\Command\Parse\Request\Handler as ParseHandler;
use App\Parser\Command\Process\Request\Handler as ProcessHandler;
use App\Parser\Entity\Options;


class ParserHandler
{
    private InputHandler $inputHandler;
    private ParseHandler $parseHandler;
    private ProcessHandler $processHandler;
    public function __construct(InputHandler $inputHandler, ParseHandler $parseHandler, ProcessHandler $processHandler)
    {
        $this->inputHandler = $inputHandler;
        $this->parseHandler = $parseHandler;
        $this->processHandler = $processHandler;

    }
    public function handle(ParserCommand $parserCommand): array
    {
        $parser = $this->inputHandler->handle($parserCommand);
        $rawData = $this->parseHandler->handle(new ParseCommand($parser));

        return $this->processHandler->handle(
            new ProcessCommand(
                $rawData,
                new Options($parserCommand->options)
            )
        );
    }
}
