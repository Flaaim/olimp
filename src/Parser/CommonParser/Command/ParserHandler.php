<?php

namespace App\Parser\CommonParser\Command;

use App\Parser\CommonParser\Command\AnswerParse\Request\Command as AnswersCommand;
use App\Parser\CommonParser\Command\AnswerParse\Request\Handler as AnswerParser;
use App\Parser\CommonParser\Command\Input\Request\Handler as InputHandler;
use App\Parser\CommonParser\Command\Process\Request\Command as ProcessCommand;
use App\Parser\CommonParser\Command\Process\Request\Handler as ProcessHandler;
use App\Parser\CommonParser\Command\QuestionParse\Request\Command as QuestionCommand;
use App\Parser\CommonParser\Command\QuestionParse\Request\Handler as QuestionParser;
use App\Parser\Entity\Parser\Options;
use App\Parser\Service\Common\CommonBuilder;
use App\Parser\Service\Common\CommonImageHandler;
use App\Parser\Service\Common\CommonSanitizer;
use App\Parser\Service\Common\CommonValidator;
use App\Parser\Service\TicketProcessor;
use App\Service\ImageHandler;
use App\Service\TextSanitizer;
use App\Shared\Domain\Response\TicketResponse;
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
    public function handle(ParserCommand $parserCommand): TicketResponse
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
                new CommonSanitizer(
                    new TextSanitizer()
                ),
                new CommonBuilder(),
                new CommonValidator(),
                new CommonImageHandler(
                    new ImageHandler(
                        $parser->getHost(),
                    )
                ),
            ))->createTicket($questionWithAnswers);

            return TicketResponse::fromResult($ticket);

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

