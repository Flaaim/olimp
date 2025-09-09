<?php

namespace App\Ticket\Service\ImageDownloader;

class PathBuilder
{
    private string $basePath;
    private string $currentPath;
    private string $questionPath;
    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, DIRECTORY_SEPARATOR);
    }
    public function forTicket(string $ticketId): self
    {
        $this->currentPath = $this->basePath . DIRECTORY_SEPARATOR . $ticketId;
        $this->basePath = $this->currentPath;
        return $this;
    }
    public function forQuestion(string $questionId): self
    {
        $this->currentPath = $this->basePath . DIRECTORY_SEPARATOR . $questionId;
        $this->questionPath = $this->currentPath;
        return $this;
    }
    public function forAnswer(string $answerId): self
    {
        if (empty($this->questionPath)) {
            throw new \DomainException('Call forQuestion() before forAnswer()');
        }
        $this->currentPath = $this->questionPath . DIRECTORY_SEPARATOR . $answerId;
        return $this;
    }
    public function create(): void
    {
        if (!is_dir($this->currentPath)) {
            mkdir($this->currentPath, 0777, true);
        }
    }
    public function getImagePath(string $filename): string
    {
        return $this->currentPath . DIRECTORY_SEPARATOR . trim($filename, DIRECTORY_SEPARATOR);
    }
}
