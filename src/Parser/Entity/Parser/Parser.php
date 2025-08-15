<?php

namespace App\Parser\Entity\Parser;

class Parser
{
    private Id $id;
    private Host $host;
    private Course  $course;
    private Cookie  $cookie;
    public function __construct(Id $id, Host $host, Course $course, Cookie $cookie)
    {
        $this->id = $id;
        $this->host = $host;
        $this->course = $course;
        $this->cookie = $cookie;
    }

    public function getHost(): Host
    {
        return $this->host;
    }

    public function getCourse(): Course
    {
        return $this->course;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getCookie(): Cookie
    {
        return $this->cookie;
    }
}
