<?php

namespace App\Ticket\Service\ImageDownloader;

class PathBuilder
{
    private string $basePath;
    private string $currentPath;
    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, DIRECTORY_SEPARATOR);
        $this->currentPath = $this->basePath;
    }
    public function forTicket(string $ticketId): self
    {
        $this->currentPath = $this->basePath . DIRECTORY_SEPARATOR . $ticketId;
        return $this;
    }
    public function forQuestion(string $questionId): self
    {
        $this->currentPath = $this->currentPath . DIRECTORY_SEPARATOR . $questionId;
        return $this;
    }
    public function create(): void
    {
        if (!is_dir($this->currentPath)) {
            mkdir($this->currentPath, 0777, true);
        }
    }
    public function getPath(): string
    {
        return $this->currentPath;
    }

    public function getImagePath(string $filename): string
    {
        if(empty($filename)) {
            throw new \InvalidArgumentException('Image filename is empty');
        }
        return $this->currentPath . DIRECTORY_SEPARATOR . trim($filename, DIRECTORY_SEPARATOR);
    }
}
