<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface UserInterface
{
    public function create(array $userDetails);
    public function findById(int $modelId, array $columns = ['*'], array $relations = []);

    public function update(array $newUserDetails, Model $model);

    public function delete(Model $model);


}
