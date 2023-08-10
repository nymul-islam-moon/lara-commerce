<?php

namespace App\Service;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use App\Interface\ProductCategoryInterface;

class ProductCategoryService implements ProductCategoryInterface
{
    public function all()
    {
        $categories = ProductCategory::latest()->get();
        return $categories;
    }

    public function store(array $formData)
    {
        $formData['created_by'] = auth()->user()->id;

        $formData['slug'] = Str::slug($formData['name'], '-');

        if ($formData['status'] == 1) {
            $formData['status'] = 1;
        }else {
            $formData['status'] = 0;
        }


        $productCategory = ProductCategory::create($formData);

        return $productCategory;
    }


    public function update($productCategory, array $formData)
    {
        $formData['updated_by_id'] = auth()->user()->id;

        $formData['slug'] = Str::slug($formData['name'], '-');


        if ($formData['status'] == 1) {
            $formData['status'] = 1;
        }else {
            $formData['status'] = 0;
        }

        $productCategory->update($formData);

        return $productCategory;

    }

}
