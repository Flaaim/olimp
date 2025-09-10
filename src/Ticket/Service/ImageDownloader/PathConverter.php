<?php

namespace App\Ticket\Service\ImageDownloader;

use App\Parser\Entity\Ticket\Ticket;
use Webmozart\Assert\Assert;

class PathConverter
{
    public function __construct(private readonly UrlBuilder $urlBuilder){}

    public function convert(Ticket $ticket, array $results): void
    {
        $this->convertQuestionImages($ticket, $results['questions']);
        $this->convertAnswerImages($ticket, $results['answers']);
    }
    private function convertQuestionImages(Ticket $ticket, array $results): void
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
    private function convertAnswerImages(Ticket $ticket, array $results): void
    {
        foreach ($results as $result) {
            if($result['status'] === 'success') {
                $ticket->updateAnswerImagesUrl(
                    $result['answer_id'],
                    $this->urlBuilder->buildNewAnswerUrl($result['path'])
                );
            }
        }
    }
}
