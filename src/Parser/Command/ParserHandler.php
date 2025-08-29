<?php

namespace App\Parser\Command;

use App\Parser\Command\Input\Request\Handler as InputHandler;
use App\Parser\Command\QuestionParse\Request\Command as QuestionCommand;
use App\Parser\Command\QuestionParse\Request\Handler as QuestionParser;
use App\Parser\Command\Process\Request\Command as ProcessCommand;
use App\Parser\Command\Process\Request\Handler as ProcessHandler;
use App\Parser\Command\AnswerParse\Request\Handler as AnswerParser;
use App\Parser\Command\AnswerParse\Request\Command as AnswersCommand;
use App\Parser\Entity\Parser\Options;
use App\Parser\ResponseParse;
use App\Parser\Service\TicketImageHandler;
use App\Parser\Service\TicketProcessor;
use App\Parser\Service\TicketSanitizer;
use App\Parser\Service\TicketBuilder;
use App\Parser\Service\TicketValidator;
use App\Service\ImageHandler;
use App\Service\TextSanitizer;
use GuzzleHttp\Exception\GuzzleException;


class ParserHandler
{
    public function __construct(
        private readonly InputHandler        $inputHandler,
        private readonly QuestionParser      $questionParser,
        private readonly ProcessHandler      $processHandler,
        private readonly AnswerParser        $answerParser,
    )
    {}
    public function handle(ParserCommand $parserCommand): ResponseParse
    {
        try {
            $parser = $this->inputHandler->handle($parserCommand);
            $rawData = $this->questionParser->handle(new QuestionCommand($parser));

            $questions = $this->processHandler->handle(
                new ProcessCommand(
                    $rawData,
                    new Options($parserCommand->options)
                )
            );

            $questionWithAnswers = $this->answerParser->handle(
                new AnswersCommand(
                    $questions,
                    $parser,
                )
            );

            $ticket = (new TicketProcessor(
                new TicketSanitizer(
                    new TextSanitizer()
                ),
                new TicketBuilder(),
                new TicketValidator(),
                new TicketImageHandler(
                    new ImageHandler(
                        $parser->getHost(),
                    )
                ),
            ))->createTicket($questionWithAnswers);

            return ResponseParse::fromTicket($ticket);

        } catch(GuzzleException $e){
            throw new \RuntimeException(
                'Failed to fetch data: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }

    }
}

