<?php

namespace App\Ticket\Service\ImageDownloader;

use App\Parser\Entity\Ticket\Question;
use App\Parser\Entity\Ticket\Ticket;
use GuzzleHttp\Client;

class ImageDownloader
{
    public function __construct(
        private readonly PathBuilder    $builder,
        private readonly Client         $client,
        private readonly Ticket         $ticket,
    )
    {
        $this->builder
            ->forTicket($ticket->getId()->getValue());
    }
    public function download(): array
    {
        $results = [];
        /** @var Question $question */
        foreach ($this->ticket->getQuestions() as $question) {
                if (!$this->shouldDownloadImage($question)) {
                    continue;
                }

                $this->builder
                    ->forQuestion($question->getId())
                        ->create();

                $imagePath = $this->builder->getImagePath(basename($question->getQuestionMainImg()));
                $results[] = $this->downloadQuestionImage($question, $imagePath);
                sleep(1);
        }
        return $results;
    }

    private function shouldDownloadImage(Question $question): bool
    {
        return !empty($question->getQuestionMainImg()) &&
            filter_var($question->getQuestionMainImg(), FILTER_VALIDATE_URL);
    }

    private function downloadQuestionImage(Question $question, string $imagePath): array
    {
        try {
            $this->client->get($question->getQuestionMainImg(), ['sink' => $imagePath,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                ],
                'timeout' => 30,
                'connect_timeout' => 10
            ]);

            return [
                'question_id' => $question->getId(),
                'url' => $question->getQuestionMainImg(),
                'status' => 'success',
                'path' => $imagePath,
                'downloaded_at' => new \DateTimeImmutable()
            ];

        } catch (\Exception $e) {
            return [
                'question_id' => $question->getId(),
                'url' => $question->getQuestionMainImg(),
                'status' => 'error',
                'error' => $e->getMessage(),
                'attempted_at' => new \DateTimeImmutable()
            ];
        }


    }
}
