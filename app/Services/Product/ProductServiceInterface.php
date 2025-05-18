<?php

namespace App\Services\Product;

use Illuminate\Http\Request;

interface ProductServiceInterface
{
    public function store(Request $request);
    public function update(Request $request, $product);
}
