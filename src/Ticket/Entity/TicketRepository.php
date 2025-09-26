<?php

namespace App\Ticket\Entity;

use App\Parser\Entity\Ticket\Ticket;
use App\Shared\Domain\ValueObject\Id;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class TicketRepository
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly EntityRepository $repo
    )
    {}
    public function addOrUpdate(Ticket $ticket): void
    {
        $existing = $this->findExisting($ticket);
        if($existing) {
            $existing->updateFrom($ticket);
        }else{
            $this->em->persist($ticket);
        }
    }
    public function getById(Id $id): Ticket
    {
        $ticket = $this->repo->find($id);
        if(!$ticket) {
            throw new \DomainException('Ticket not found.');
        }
        return $ticket;
    }
    public function remove(Ticket $ticket): void
    {
        $this->em->remove($ticket);
    }
    private function findExisting(Ticket $ticket): ?Ticket
    {
        return $this->repo->find($ticket->getId()->getValue());
    }
    public function findAllPaginated(
        ?string $searchQuery,
        ?string $sortBy = 'name',
        ?string $sortOrder = 'asc',
        int $page = 1,
        int $perPage = 20,
    ): PaginatedResults
    {
        $queryBuilder = $this->createFilteredQueryQueryBuilder($searchQuery);
        $allowedSortFields = ['name', 'cipher', 'updatedAt'];

        $sortBy = in_array($sortBy, $allowedSortFields) ? $sortBy : 'name';
        $sortOrder = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC';

        $queryBuilder->orderBy('t.' . $sortBy, $sortOrder);

        $query = $queryBuilder->getQuery();
        $paginator = new Paginator($query);

        $paginator
            ->getQuery()
            ->setFirstResult($perPage * ($page - 1))
            ->setMaxResults($perPage);

        $total = count($paginator);
        $results = [];

        foreach ($paginator as $product) {
            $results[] = $product;
        }

        return PaginatedResults::create($results, $total, $page, $perPage);
    }
    private function createFilteredQueryQueryBuilder(?string $searchQuery): QueryBuilder
    {
        $queryBuilder = $this->repo->createQueryBuilder('t');
        if ($searchQuery !== null) {
            $queryBuilder
                ->andWhere('t.name LIKE :searchQuery OR t.cipher LIKE :searchQuery')
                ->setParameter('searchQuery', '%' . $searchQuery . '%');
        }
        return $queryBuilder;
    }
}
