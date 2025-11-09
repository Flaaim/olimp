<?php

namespace App\Parser\Service\Gpn;

use App\Parser\Service\Interface\TicketImageHandler;
use App\Service\ImageHandler;

final class GpnImageHandler implements TicketImageHandler
{
    public function __construct(
        private readonly ImageHandler $imageHandler,
    )
    {}
    public function handle(array $rawQuestions): array
    {
        return array_map(
            fn ($questionData) => [
                ...$questionData,
                'Text' => $questionData['content'],
                'QuestionMainImg' => $this->extractAndProcessMainImage($questionData['questionImg']),
                'answers' => array_map(
                    fn ($answerData) => [
                        ...$answerData,
                        'Text' => $answerData['content'],
                        'Correct' => $answerData['isCorrect'],
                        'Img' => $this->extractImagesFromContent($answerData['content']),
                    ],
                    $questionData['answers']
                )
            ],
            $rawQuestions
        );
    }
    private function extractAndProcessMainImage(string $imageHtml): string
    {
        return $this->imageHandler->extractAndProcessMainImage($imageHtml);
    }

    private function extractImagesFromContent(string $content): string
    {
        return $this->imageHandler->extractImagesFromContent($content);
    }
}
