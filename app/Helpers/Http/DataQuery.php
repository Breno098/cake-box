<?php

namespace App\Helpers\Http;

trait DataQuery
{
    /**
     * @var string
     */
    private string $defaultOrderBy = 'id';

     /**
     * @var int
     */
    private int $defaultRowsPerPage = 10;

    /**
     * @var string
     */
    private string $defaultSort = 'asc';

    /**
     * @return integer
     */
    public function page(): int
    {
        return request()->get('page', 1);
    }

    /**
     * @param integer $defaultRowsPerPage
     * @return integer
     */
    public function rowsPerPage(null|int $defaultRowsPerPage = null): int
    {
        $this->defaultRowsPerPage = $defaultRowsPerPage ?? $this->defaultRowsPerPage;

        return request()->get('rowsPerPage', $this->defaultRowsPerPage);
    }

    /**
     * @param string $defaultSort
     * @return string
     */
    public function sort(string $defaultSort = null): string
    {
        $this->defaultSort = $defaultSort ?? $this->defaultSort;

        return request()->get('sort', $this->defaultSort);
    }

    /**
     * @param string $defaultOrderBy
     * @return string
     */
    public function orderBy(null|string $defaultOrderBy = null): string
    {
        $this->defaultOrderBy = $defaultOrderBy ?? $this->defaultOrderBy;

        return request()->get('orderBy', $this->defaultOrderBy);
    }

    /**
     * @return array
     */
    public function filters(): array
    {
        return request()->get('filters', []);
    }

    /**
     * @return array
     */
    public function dataQuery(): array
    {
        return [
            'orderBy' => $this->orderBy(),
            'sort' => $this->sort(),
            'filters' => $this->filters(),
            'rowsPerPage' => $this->rowsPerPage(),
            'page' => $this->page(),
        ];
    }
}
