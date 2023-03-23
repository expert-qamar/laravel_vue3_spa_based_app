<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface CategoriesInterface
{
    public function pagination($request);

    public function all();

    public function create(array $CategoriesDetails);

    public function update(array $CategoriesDetails, Model $modal);

    public function delete(Model $model);

}
