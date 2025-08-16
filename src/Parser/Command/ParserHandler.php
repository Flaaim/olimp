<?php

namespace App\Parser\Command;

use App\Parser\Command\Input\Request\Handler as InputHandler;
use App\Parser\Command\Parse\Request\Command as ParseCommand;
use App\Parser\Command\Parse\Request\Handler as ParseHandler;
use App\Parser\Command\Process\Request\Command as ProcessCommand;
use App\Parser\Command\Process\Request\Handler as ProcessHandler;
use App\Parser\Entity\Parser\Options;
use App\Parser\Service\QuestionProcessor;
use App\Parser\Service\QuestionSanitizer;
use App\Parser\Service\QuestionsBuilder;



class ParserHandler
{
    public function __construct(
        private readonly InputHandler        $inputHandler,
        private readonly ParseHandler        $parseHandler,
        private readonly ProcessHandler      $processHandler,
    )
    {}
    public function handle(ParserCommand $parserCommand): array
    {
        $parser = $this->inputHandler->handle($parserCommand);
        $rawData = $this->parseHandler->handle(new ParseCommand($parser));

        $questions = $this->processHandler->handle(
            new ProcessCommand(
                $rawData,
                new Options($parserCommand->options)
            )
        );

        $ticket = (new QuestionProcessor(
            new QuestionSanitizer(),
            new QuestionsBuilder()
        ))->createTicket($questions);

        return $ticket->getQuestions();
    }
}
