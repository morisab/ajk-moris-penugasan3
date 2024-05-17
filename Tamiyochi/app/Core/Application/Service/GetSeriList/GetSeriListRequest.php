<?php

namespace App\Core\Application\Service\GetSeriList;

class GetSeriListRequest
{
    private int $per_page;
    private int $page;
    private ?array $filter;
    private ?string $search;

    public function __construct(int $per_page, int $page, ?array $filter, ?string $search)
    {
        $this->per_page = $per_page;
        $this->page = $page;
        $this->filter = $filter;
        $this->search = $search;
    }

    public function getPerPage(): int
    {
        return $this->per_page;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getFilter(): ?array
    {
        return $this->filter;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }
}
