<?php

namespace App\Parser\Service\Common;

use App\Parser\Service\Interface\TicketImageHandler;
use App\Service\ImageHandler;

final class CommonImageHandler implements TicketImageHandler
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
                'Text' => $questionData['Text'],
                'QuestionMainImg' => $this->extractAndProcessMainImage($questionData['QuestionMainImg']),
                'answers' => array_map(
                    fn ($answerData) => [
                        ...$answerData,
                        'Text' => $answerData['Text'],
                        'Correct' => $answerData['Correct'],
                        'Img' => $this->extractImagesFromContent($answerData['Text']),
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
