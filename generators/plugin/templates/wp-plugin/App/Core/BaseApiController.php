<?php

namespace <%- props.appName %>\Core;

use <%- props.appName %>\Exceptions\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\Cursor;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

abstract class BaseAPIController
{

    protected $primaryKey = 'id';

    /**
     * HTTP header status code.
     *
     * @var int
     */
    protected $statusCode = 200;

    /**
     * Fractal Manager instance.
     *
     * @var Manager
     */
    protected $fractal;

    /**
     * Eloquent model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model;
     */
    protected $model;

    /**
     * Fractal Transformer instance.
     *
     * @var \League\Fractal\TransformerAbstract
     */
    protected $transformer;

    /**
     * Resource key for an item.
     *
     * @var string
     */
    protected $resourceKeySingular = 'data';

    /**
     * Resource key for a collection.
     *
     * @var string
     */
    protected $resourceKeyPlural = 'data';

    /**
     * Constructor.
     *
     * @param Request $request
     */
    public function __construct($container)
    {
        $this->container        = $container;
        $this->repository       = $this->repository();
        $this->transformer      = $this->transformer();

        $this->fractal = new Manager();

        if (isset($_REQUEST['include'])) {
            $this->fractal->parseIncludes($_REQUEST['include']);
        }
    }

    /**
     * Eloquent model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    abstract protected function repository();
    abstract protected function getId();

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    abstract protected function transformer();

    /**
     * Display a listing of the resource.
     * GET /api/{resource}.
     *
     * @return Response
     */
    public function index()
    {
        $input = $this->container['request']->all();

        $items = $this->repository->paginate($input);

        $items->setPath(($_SERVER['SCRIPT_NAME']));

        foreach ($_GET as $key => $value) {
            $items->addQuery($key, $value);
        }

        return $this->respondWithPaginator($items);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/{resource}.
     *
     * @return Response
     */
    public function store()
    {
        $data = $this->container['request']->all();

        try {
            $item = $this->repository->create($data);
        } catch (ValidationException $e) {
            return $this->errorUnprocessableEntity($e->errors());
        }

        return $this->respondWithItem($item);
    }

    /**
     * Display the specified resource.
     * GET /api/{resource}/{id}.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show()
    {
        $id   = $this->getId();
        try {
            $item = $this->repository->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->errorNotFound();
        }

        return $this->respondWithItem($item);
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/{resource}/{id}.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update()
    {
        $data = $this->container['request']->all();
        $id   = $this->getId();

        if (!$data) {
            return $this->errorWrongArgs('Empty data');
        }

        try {
            $item = $this->findItem($id);
        } catch (ModelNotFoundException $e) {
            return $this->errorNotFound();
        }

        try {
            $item = $this->repository->update($data, $id);
        } catch (ValidationException $e) {
            return $this->errorUnprocessableEntity($e->errors());
        }

        return $this->respondWithItem($item);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/{resource}/{id}.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy()
    {
        $id    = null;

        if (isset($_POST[$this->primaryKey])) {
            $id = $_POST[$this->primaryKey];
        }

        try {
            $this->repository->delete($id);
        } catch (ModelNotFoundException $e) {
            return $this->errorNotFound();
        }

        return $this->respondWithArray(['message' => 'Deleted']);
    }

    /**
     * Show the form for creating the specified resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->errorNotImplemented();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        return $this->errorNotImplemented();
    }

    /**
     * Getter for statusCode.
     *
     * @return int
     */
    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Setter for statusCode.
     *
     * @param int $statusCode Value to set
     *
     * @return self
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Respond with a given item.
     *
     * @param $item
     *
     * @return mixed
     */
    protected function respondWithItem($item)
    {
        $resource = new Item($item, $this->transformer, $this->resourceKeySingular);

        $rootScope = $this->prepareRootScope($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    protected function respondWithPaginator($paginator)
    {
        $resource = new Collection($paginator->getCollection(), $this->transformer, $this->resourceKeyPlural);

        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        $rootScope = $this->prepareRootScope($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    /**
     * Respond with a given collection.
     *
     * @param $collection
     * @param int $skip
     * @param int $limit
     *
     * @return mixed
     */
    protected function respondWithCollection($collection, $skip = 0, $limit = 0)
    {
        $resource = new Collection($collection, $this->transformer, $this->resourceKeyPlural);

        if ($limit) {
            $cursor = new Cursor($skip, $skip + $limit, $collection->count());
            $resource->setCursor($cursor);
        }

        $rootScope = $this->prepareRootScope($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    /**
     * Respond with a given array of items.
     *
     * @param array $array
     * @param array $headers
     *
     * @return mixed
     */
    protected function respondWithArray(array $array, array $headers = [])
    {
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code($this->statusCode);
        echo json_encode($array);
        die();
    }

    /**
     * Response with the current error.
     *
     * @param string $message
     *
     * @return mixed
     */
    protected function respondWithError($message)
    {
        return $this->respondWithArray([
            'error' => [
                'http_code' => $this->statusCode,
                'message'   => $message,
            ],
        ]);
    }

    /**
     * Prepare root scope and set some meta information.
     *
     * @param Item|Collection $resource
     *
     * @return \League\Fractal\Scope
     */
    protected function prepareRootScope($resource)
    {
        $resource->setMetaValue('available_includes', $this->transformer->getAvailableIncludes());
        $resource->setMetaValue('default_includes', $this->transformer->getDefaultIncludes());

        return $this->fractal->createData($resource);
    }

    protected function errorUnprocessableEntity($errors)
    {
        return $this->setStatusCode(422)->respondWithError($errors);
    }

    /**
     * Generate a Response with a 403 HTTP header and a given message.
     *
     * @param $message
     *
     * @return Response
     */
    protected function errorForbidden($message = 'Forbidden')
    {
        return $this->setStatusCode(403)->respondWithError($message);
    }

    /**
     * Generate a Response with a 500 HTTP header and a given message.
     *
     * @param string $message
     *
     * @return Response
     */
    protected function errorInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }

    /**
     * Generate a Response with a 404 HTTP header and a given message.
     *
     * @param string $message
     *
     * @return Response
     */
    protected function errorNotFound($message = 'Resource Not Found')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * Generate a Response with a 401 HTTP header and a given message.
     *
     * @param string $message
     *
     * @return Response
     */
    protected function errorUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(401)->respondWithError($message);
    }

    /**
     * Generate a Response with a 400 HTTP header and a given message.
     *
     * @param string$message
     *
     * @return Response
     */
    protected function errorWrongArgs($message = 'Wrong Arguments')
    {
        return $this->setStatusCode(400)->respondWithError($message);
    }

    /**
     * Generate a Response with a 501 HTTP header and a given message.
     *
     * @param string $message
     *
     * @return Response
     */
    protected function errorNotImplemented($message = 'Not implemented')
    {
        return $this->setStatusCode(501)->respondWithError($message);
    }

    /**
     * Get item according to mode.
     *
     * @param int   $id
     * @param array $with
     *
     * @return mixed
     */
    protected function findItem($id, array $with = [])
    {
        return $this->repository->find($id);
    }
}
