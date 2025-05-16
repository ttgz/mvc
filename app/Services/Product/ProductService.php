<?php

namespace App\Services\Product;

use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductService implements ProductServiceInterface
{
    protected $repository;

    public function __construct(
        ProductRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }
    public function store(Request $request)
    {
        $data = $request->validated();
        return $this->repository->create($data);
    }
}
