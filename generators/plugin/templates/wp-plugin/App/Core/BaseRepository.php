<?php
namespace <%- props.appName %>\Core;

use <%- props.appName %>\Exceptions\ValidationException;
use Illuminate\Container\Container as <%- props.appName %>lication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Validator;

/**
 * Class BaseRepository
 * @package Prettus\Repository\Eloquent
 */
abstract class BaseRepository
{

    public $primaryKey = 'id';

    /**
     * @var <%- props.appName %>lication
     */
    protected $container;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @param <%- props.appName %>lication $app
     */
    public function __construct($container)
    {
        $this->container      = $container;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function makeModel();

    abstract public function createRules($attributes);
    abstract public function updateRules($attributes, $id);

    /**
     * Retrieve data array for populate field select
     *
     * @param string      $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function lists($input, $column, $key = null)
    {
        return $this->searchQuery($input)->lists($column, $key);
    }

    /**
     * Retrieve all data of repository
     *
     * @param  array $columns
     * @return mixed
     */
    public function all($input = array(), $columns = array('*'))
    {
        return $this->searchQuery($input)->select($columns)->get();
    }

    /**
     * Retrieve paginated data
     *
     * @param array $input [description]
     *
     * @return [type] [description]
     */
    public function paginate($input = array())
    {
        return $this->searchQuery($input)->paginate();
    }

    public function searchQuery($input)
    {
        return $this->makeModel()->search($input);
    }

    /**
     * Retrieve first data of repository
     *
     * @param  array $columns
     * @return mixed
     */
    public function first($input, $columns = array('*'))
    {
        return $this->searchQuery($input)->select($columns)->first();
    }

    /**
     * Find data by id
     *
     * @param $id
     * @param  array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        return $this->makeModel()->findOrFail($id, $columns);
    }

    /**
     * Save a new entity in repository
     *
     * @throws ValidationException
     * @param  array               $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        // dd($attributes);
        $rules     = $this->createRules($attributes);
        // dd($rules);
        $validator = $this->container['validator']->make($attributes, $rules);

        if ($validator->passes()) {
            $model = $this->makeModel()->fill($attributes);
            $model->save();

            return $model;
        } else {
            throw new ValidationException($validator);
        }
    }

    /**
     * Update a entity in repository by id
     *
     * @throws ValidationException
     * @param  array               $attributes
     * @param $id
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        $rules     = $this->updateRules($attributes, $id);
        $validator = $this->container['validator']->make($attributes, $rules);

        $model = $this->find($id);

        if ($validator->passes()) {
            $model->fill($attributes);
            $model->save();

            return $model;
        } else {
            throw new ValidationException($validator);
        }
    }

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        $model   = $this->find($id);
        $deleted = $model->delete();

        return $deleted;
    }
}
