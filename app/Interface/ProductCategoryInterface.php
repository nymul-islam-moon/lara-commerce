<?php

namespace App\Interface;

interface ProductCategoryInterface
{
    public function all();

    public function store(array $request);

    public function update($productCategory, array $request);

}
