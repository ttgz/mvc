<?php

namespace App\Http\Controllers\Product;

use App\Supports\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\Product\ProductResourceCollection;
use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Product\ProductServiceInterface;
use App\Supports\JsonResponse;
use Illuminate\Foundation\Exceptions\Renderer\Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use JsonResponse, Log;

    public function __construct(
        ProductRepositoryInterface $repository,
        ProductServiceInterface $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }
    //
    public function index(ProductRequest $request)
    {
        $data = $request->validated();

        $limit = $data['limit'] ?? 10;
        $page = $data['page'] ?? 1;

        $products = $this->repository->getWithPagination($limit, $page);
        return $this->jsonResponseSuccess(new ProductResourceCollection($products));
    }

    public function store(ProductRequest $request)
    {
        try {
            $product = $this->service->store($request);
            if ($product)
                return $this->jsonResponseSuccessNoData('', 201);
            return $this->jsonResponseError();
        } catch (\Exception $e) {
            $this->logError($e->getMessage(), $e);
            return $this->jsonResponseError('Lỗi hệ thống!', 500);
        }
    }

    public function detail(Product $product)
    {
        return $product;
    }
}
