<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * BaseRepository
 * @package App\Repositories
 */
abstract class BaseRepository
{
    /**
     * @var Model $model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

     /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all() : Collection
    {
        return $this->model->all();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function store(array $data) : ?Model
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @return bool
     */
    public function update(array $data, $id) : bool
    {
        $sub = $this->model->find($id);
        return $sub->update($data);
    }

    /**
     * @param $id
     * @return bool
     */
    public function destroy($id) : bool
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @return Model
     */
    public function show($id) : Model
    {
        return $this->model->findOrFail($id);
    }

     /**
     * @param $id
     * @return Collection
     */
    public function findBy(string $column, $value) : Collection
    {
        return $this->model
            ->where($column, '=', $value)
            ->get();
    }

    /**
     * get a builder for the model
     *
     * @return Builder
     */
    public function query() : Builder
    {
        return $this->model->query();
    }
}
