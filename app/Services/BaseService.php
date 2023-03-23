<?php

namespace App\Services;

use Arr;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseService
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    public function first(array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->model->with($relations)->first($columns);
    }

    public function create(array $payload): ?Model
    {
        return $this->model->create(Arr::only($payload, $this->model->fillable));
    }

    public function update(array $payload, Model $model): ?Model
    {
        $model->update(Arr::only($payload, $model->fillable));

        return $model;
    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    public function findById(int $modelId, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->model->select($columns)->with($relations)->findOrFail($modelId);
    }

    public function firstOneWith(array $columns = ['*'], array $whereClause = [], array $relations = []): ?Model
    {
        return $this->model->select($columns)->with($relations)->where($whereClause)->first();
    }
}
