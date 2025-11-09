<?php

namespace App\Parser\GpnParser\Command;

use App\Parser\GpnParser\Command\CheckQuestion\Request\Command as CheckQuestionCommand;
use App\Parser\GpnParser\Command\CheckQuestion\Request\Handler as CheckQuestionHandler;
use App\Parser\GpnParser\Command\Input\Request\Handler as InputHandler;
use App\Parser\GpnParser\Command\QuestionParse\Request\Command as QuestionCommand;
use App\Parser\GpnParser\Command\QuestionParse\Request\Handler as QuestionParser;
use App\Parser\Service\Gpn\GpnBuilder;
use App\Parser\Service\Gpn\GpnImageHandler;
use App\Parser\Service\Gpn\GpnSanitizer;
use App\Parser\Service\Gpn\GpnValidator;
use App\Parser\Service\TicketProcessor;
use App\Service\ImageHandler;
use App\Service\TextSanitizer;
use App\Shared\Domain\Response\TicketResponse;

class ParserHandler
{
    public function __construct(
        private readonly InputHandler $inputHandler,
        private readonly QuestionParser $questionParser,
        private readonly CheckQuestionHandler $checkQuestionHandler,
    ){}
    public function handle(ParserCommand $command): TicketResponse
    {
        $parser = $this->inputHandler->handle($command);

        $rawData = $this->questionParser->handle(new QuestionCommand($parser));

        $command = new CheckQuestionCommand(
            $rawData['question'],
            $rawData['materialId'],
            $parser
        );
        $data = $this->checkQuestionHandler->handle($command);

        $ticket = (new TicketProcessor(
            new GpnSanitizer(
                new TextSanitizer()
            ),
            new GpnBuilder(),
            new GpnValidator(),
            new GpnImageHandler(
                new ImageHandler(
                    $parser->getHost(),
                ))
        ))->createTicket($data);

        return TicketResponse::fromResult($ticket);
    }
}
