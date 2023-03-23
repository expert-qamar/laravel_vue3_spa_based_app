<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface CarsDetailInterface
{
    public function pagination($request);

    public function create(array $detailArray);

    public function update(array $newHealthBoardDetails, Model $modal);

    public function delete(Model $model);
    public function findById(int $modelId );

}
