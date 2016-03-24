<?php

namespace <%- props.namespace %>\Http\Controllers\API;

use <%- props.namespace %>\Core\BaseAPIController;
use <%- props.namespace %>\Repositories\<%- props.className %>Repository;
use <%- props.namespace %>\Transformers\<%- props.className %>Transformer;

class <%- props.className %> extends BaseAPIController
{
    protected $primaryKey = 'id';

    public function repository()
    {
        return new <%- props.className %>Repository($this->container);
    }

    public function transformer()
    {
        return new <%- props.className %>Transformer;
    }
}
