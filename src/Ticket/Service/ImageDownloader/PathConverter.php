<?php

namespace App\Ticket\Service\ImageDownloader;

use App\Parser\Entity\Ticket\Ticket;

class PathConverter
{
    public function __construct(private readonly UrlBuilder $urlBuilder){}


    public function convert(Ticket $ticket, array $results): void
    {
        foreach ($results as $result) {
            if($result['status'] === 'success') {
                $ticket->updateQuestionImagesUrl(
                    $result['question_id'],
                    $this->urlBuilder->buildNewQuestionUrl($result['path'])
                );
            }
        }
}
}
