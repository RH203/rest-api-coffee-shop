<?php

namespace App\Repository;

use App\Models\Categories;

class CategoryRepository
{
    public function findCategoryById($categoryId)
    {
        return Categories::find($categoryId);
    }
}
