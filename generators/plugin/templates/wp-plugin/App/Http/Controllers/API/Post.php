<?php

namespace <%- props.appName %>\Http\Controllers\API;

use <%- props.appName %>\Core\BaseAPIController;
use <%- props.appName %>\Repositories\PostRepository;
use <%- props.appName %>\Transformers\PostTransformer;

class Post extends BaseAPIController
{
    protected $primaryKey = 'id';

    public function repository()
    {
        return new PostRepository($this->container);
    }

    public function transformer()
    {
        return new PostTransformer;
    }

    public function getId()
    {
        if (isset($_GET['id'])) {
            return $_GET['id'];
        }
    }
}
