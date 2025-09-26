<?php

namespace App\Permit\Entity;

interface AccessRepository
{
    public function create(Access $access);
}
