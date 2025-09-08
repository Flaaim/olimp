<?php

namespace App\Ticket\Command\Save\Request;

use App\Flusher;
use App\Parser\Entity\Ticket\Ticket;
use App\Ticket\Command\Save\Response\Response;
use App\Ticket\Entity\TicketRepository;
use App\Ticket\Service\ImageDownloader\ImageDownloader;
use App\Ticket\Service\ImageDownloader\PathBuilder;
use App\Ticket\Service\ImageDownloader\PathConverter;
use App\Ticket\Service\ImageDownloader\UrlBuilder;
use GuzzleHttp\ClientInterface;


class Handler
{
    public function __construct(
        private readonly TicketRepository   $tickets,
        private readonly Flusher            $flusher,
        private readonly PathBuilder        $path,
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
        ))->download();

        $converter = new PathConverter($this->urlBuilder);
        $converter->convert($ticket, $result);

        //$this->tickets->add($ticket);

        //$this->flusher->flush();

        return Response::fromResult($ticket);
    }
}
