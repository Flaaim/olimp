<?php

namespace App\Service;

class TextSanitizer
{
    public function cleanTextContent(string $text): string
    {
        // Убираем HTML теги, но оставляем переносы строк
        $cleaned = strip_tags($text, '<br>');

        // Заменяем <br> на переносы строк
        $cleaned = str_replace(['<br>', '<br/>', '<br />'], "\n", $cleaned);

        // Убираем лишние пробелы и переносы
        $cleaned = preg_replace('/\s+/', ' ', $cleaned);

        // Убираем дефисы в начале и конце
        $cleaned = preg_replace('/^-|-$/', '', $cleaned);

        return trim($cleaned);
    }

}
