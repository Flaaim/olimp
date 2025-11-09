<?php

namespace App\Parser\Entity\Parser\GpnParser;

class Course
{
    private string $questionIds;
    public string $topicId;
    public  string $materialId;

    public function __construct(string $topicId, string $materialId, string $questionIds)
    {
        $this->topicId = $topicId;
        $this->questionIds = $questionIds;
        $this->materialId = $materialId;
    }
    public function getId(): string
    {
        return $this->id;
    }
    public function getQuestionIds(): string
    {
        return $this->questionIds;
    }
    public function getTopicId(): string
    {
        return $this->topicId;
    }
    public function getMaterialId(): string
    {
        return $this->materialId;
    }

}
