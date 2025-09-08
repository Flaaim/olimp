<?php

namespace App\Service;

use App\Parser\Entity\Parser\Host;

class ImageHandler
{
    public function __construct(private readonly Host $host)
    {}

    public function extractAndProcessMainImage(string $imageHtml): string
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

    public function extractImagesFromContent(string $content): string
    {
        // Извлекаем все изображения из контента
        $images = [];

        if (preg_match_all('/<img[^>]+src="\/([^"]+)"[^>]*>/', $content, $matches)) {
            foreach ($matches[0] as $index => $imgTag) {
                $imagePath = $matches[1][$index];
                $absoluteUrl = $this->host->getValue() . $imagePath;
                $images[] = $absoluteUrl;
            }
        }

        return implode(' ', $images);
    }
}
