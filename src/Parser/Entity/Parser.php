<?php

namespace App\Parser\Entity;

class Parser
{
    private Id $id;
    private Host $host;
    private Course  $course;
    public function __construct(Id $id, Host $host, Course $course)
    {
        $this->id = $id;
        $this->host = $host;
        $this->course = $course;
    }
}
