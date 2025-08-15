<?php

namespace App\Parser\Command;

use App\Parser\Command\Input\Request\Handler as InputHandler;
use App\Parser\Command\Parse\Request\Command as ParseCommand;
use App\Parser\Command\Parse\Request\Handler as ParseHandler;
use App\Parser\Command\Process\Request\Command as ProcessCommand;
use App\Parser\Command\Process\Request\Handler as ProcessHandler;
use App\Parser\Entity\Parser\Id;
use App\Parser\Entity\Parser\Options;
use App\Parser\Entity\Ticket\Ticket;
use App\Parser\Service\QuestionDataHandler;
use App\Parser\Service\QuestionsBuilder;
use ArrayObject;
use Ramsey\Uuid\Uuid;


class ParserHandler
{
    public function __construct(
        private readonly InputHandler        $inputHandler,
        private readonly ParseHandler        $parseHandler,
        private readonly ProcessHandler      $processHandler,
        private readonly QuestionDataHandler $questionDataHandler,
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

        $ticket = new Ticket(
            new Id(Uuid::uuid4()->toString()),
            new ArrayObject(
                (new QuestionsBuilder($this->questionDataHandler, $questions))->getArray()
            )
        );

        return $ticket->getQuestions();
    }
}
