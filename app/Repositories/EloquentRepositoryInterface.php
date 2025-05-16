<?php

namespace App\Repositories;

interface EloquentRepositoryInterface
{
    public function getAll();
    public function getWithPagination($limit, $page);
    public function create(array $data);
}
