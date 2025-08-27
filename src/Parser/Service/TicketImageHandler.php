<?php

namespace App\Parser\Service;

use App\Parser\Entity\Parser\Host;

class TicketImageHandler
{

    public function __construct(private readonly Host $host)
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
        if (empty($imageHtml) || !str_contains($imageHtml, '<img')) {
            return '';
        }

        // Извлекаем путь к изображению из HTML
        if (preg_match('/src="\/([^"]+)"/', $imageHtml, $matches)) {
            return $this->host->getValue() . $matches[1];
        }

        return $imageHtml;
    }

    private function extractImagesFromContent(string $content): string
    {
        // Извлекаем все изображения из контента
        $images = [];

        if (preg_match_all('/<img[^>]+src="\/([^"]+)"[^>]*>/', $content, $matches)) {
            foreach ($matches[0] as $index => $imgTag) {
                $imagePath = $matches[1][$index];
                $absoluteUrl = $this->host->getValue() . $imagePath;
                $images[] = '<img src="' . $absoluteUrl . '">';
            }
        }

        return implode('', $images);
    }
}
