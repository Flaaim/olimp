<?php

namespace App\Parser\Entity\Parser\GpnParser;

use App\Parser\Entity\Parser\Cookie;
use App\Shared\Domain\ValueObject\Id;

class GpnParser
{
    public Id $id;
    public Course $course;
    public Host $host;
    public Cookie $cookie;

    public function __construct(Id $id, Course $course, Host $host, Cookie $cookie)
    {
        $this->id = $id;
        $this->course = $course;
        $this->host = $host;
        $this->cookie = $cookie;
    }
    public function getId(): Id
    {
        return $this->id;
    }
    public function getCourse(): Course
    {
        return $this->course;
    }
    public function getHost(): Host
    {
        return $this->host;
    }
    public function getCookie(): Cookie
    {
        return $this->cookie;
    }
}
