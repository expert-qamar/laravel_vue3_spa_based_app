<?php

namespace App\Repositories;

use App\Interfaces\CategoriesInterface;
use App\Models\Category;

use App\Services\BaseService;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoriesRepository extends BaseService implements CategoriesInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function pagination($request): LengthAwarePaginator
    {
        $orderColumn = request('order_column', 'created_at');
        $orderDirection = request('order_direction', 'desc');
        $recordPerPage =  request('limit', 5);

        return Category::select('id','name')
            ->when(request('search_global'), function ($query) {
                $query->where('name', 'like', '%'.request('search_global').'%');
            })
            ->orderBy($orderColumn, $orderDirection)
            ->paginate($recordPerPage);
    }

}
