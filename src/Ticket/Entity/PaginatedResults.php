<?php

namespace App\Ticket\Entity;

use App\Parser\Entity\Ticket\Ticket;

class PaginatedResults
{
    /**
     * @param array<Ticket> $items
     */
    public function __construct(
        public readonly array $items,
        public readonly int $totalItems,
        public readonly int $currentPage,
        public readonly int $perPage,
        public readonly int $totalPages
    ) {}

    public static function create(
        array $items,
        int $totalItems,
        int $page,
        int $perPage
    ): self {
        return new self(
            items: $items,
            totalItems: $totalItems,
            currentPage: $page,
            perPage: $perPage,
            totalPages: (int) ceil($totalItems / $perPage)
        );
    }

    public function getResults(): array
    {
        return $this->items;
    }
    public function getTotalItems(): int
    {
        return $this->totalItems;
    }
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }
    public function getPerPage(): int
    {
        return $this->perPage;
    }
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }
    public function hasNextPage(): bool
    {
        return $this->currentPage < $this->getTotalPages();
    }

    public function hasPreviousPage(): bool
    {
        return $this->currentPage > 1;
    }
}
