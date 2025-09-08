<?php

namespace App\Ticket\Service\ImageDownloader;

class PathBuilder
{
    private string $basePath;
    private string $fullPath;
    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, DIRECTORY_SEPARATOR);
    }
    public function forTicket(string $ticketId): self
    {
        $this->fullPath = $this->basePath . DIRECTORY_SEPARATOR . $ticketId;
        return $this;
    }
    public function forQuestion(string $questionId, string $ticketPath): self
    {
        $this->fullPath = $ticketPath . DIRECTORY_SEPARATOR . $questionId;
        return $this;
    }
    public function create(): void
    {
        if (!is_dir($this->fullPath)) {
            mkdir($this->fullPath, 0777, true);
        }
    }
    public function getPath(): string
    {
        return $this->fullPath;
    }

    public function getImagePath(string $filename): string
    {
        return $this->fullPath . DIRECTORY_SEPARATOR . $filename;
    }
}
