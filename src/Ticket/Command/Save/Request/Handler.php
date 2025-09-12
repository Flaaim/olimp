<?php

namespace App\Ticket\Command\Save\Request;

use App\Flusher;
use App\Parser\Entity\Ticket\Ticket;
use App\Ticket\Command\Save\Response\Response;
use App\Ticket\Entity\TicketRepository;
use App\Ticket\Service\ImageDownloader\DownloadChecker;
use App\Ticket\Service\ImageDownloader\ImageDownloader;
use App\Ticket\Service\ImageDownloader\PathConverter;
use App\Ticket\Service\ImageDownloader\PathManager;
use App\Ticket\Service\ImageDownloader\UrlBuilder;
use GuzzleHttp\ClientInterface;


class Handler
{
    public function __construct(
        private readonly TicketRepository   $tickets,
        private readonly Flusher            $flusher,
        private readonly PathManager        $path,
        private readonly UrlBuilder         $urlBuilder,
        private readonly ClientInterface    $client,
    )
    {}

    public function handle(Command $command): Response
    {
        $ticket = Ticket::fromArray($command->ticket);

        $result = (new ImageDownloader(
            $this->path,
            $this->client,
            $ticket,
            new DownloadChecker()
        ))->download();

        (new PathConverter($this->urlBuilder))
            ->convertQuestionImages($ticket, $result['questions'])
            ->convertAnswerImages($ticket, $result['answers']);

        $this->tickets->addOrUpdate($ticket);

        $this->flusher->flush();

        return Response::fromResult($ticket);
    }
}
