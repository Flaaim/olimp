<?php

namespace App\Service\Common;

interface TransactionManagerInterface
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollback(): void;
    public function transactional(callable $func): mixed;
}
