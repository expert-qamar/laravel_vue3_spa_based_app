<?php

namespace App\Repositories;

use App\Interfaces\CarsDetailInterface;
use App\Models\CarDetail;
use App\Services\BaseService;
use Illuminate\Pagination\LengthAwarePaginator;

class CarsDetailRepositories extends BaseService implements CarsDetailInterface
{
    public function __construct(CarDetail $model)
    {
        parent::__construct($model);
    }

    public function pagination($request): LengthAwarePaginator
    {
        $orderColumn = request('order_column', 'created_at');
        if (! in_array($orderColumn, ['id', 'name', 'created_at']))
            $orderColumn = 'created_at';

        $orderDirection = request('order_direction', 'desc');
        if (! in_array($orderDirection, ['asc', 'desc']))
            $orderDirection = 'desc';

        $recordPerPage =  request('limit', 5);

        return CarDetail::
            with('category')
            ->when(request('search_global'), function ($query) {
                $query->where(function ($q) {
                    $q->Where('id', request('search_global'))
                        ->orWhere('model', 'like', '%'.request('search_global').'%')
                        ->orWhere('register_no', 'like', '%'.request('search_global').'%')
                        ->orWhere('color', 'like', '%'.request('search_global').'%')
                        ->orWhere('making_year', 'like', '%'.request('search_global').'%')
                        ->orWhereHas('category', function ($query) {
                            $query->Where('name', 'like', '%'.request('search_global').'%');
                        });
                });
            })
            ->orderBy($orderColumn, $orderDirection)
            ->paginate($recordPerPage);
    }

}
