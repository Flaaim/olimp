<?php

namespace App\Service\Common;

use Doctrine\ORM\EntityManagerInterface;

class TransactionManager implements TransactionManagerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ){}

    public function beginTransaction(): void
    {
        $this->em->beginTransaction();
    }

    public function commit(): void
    {
        $this->em->commit();
    }

    public function rollback(): void
    {
        $this->em->rollback();
    }

    public function transactional(callable $func): mixed
    {
        try {
            $this->beginTransaction();
            $result = $func();

            $this->commit();
            return $result;
        }catch (\Throwable $e){
            $this->rollback();
            throw $e;
        }




    }
}
