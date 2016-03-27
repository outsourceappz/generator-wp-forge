<?php

namespace <%- props.appName %>\Core;

use <%- props.appName %>\Core\Input\DefaultInput;
use <%- props.appName %>\Core\Input\JsonInput;
use Illuminate\Support\Collection;

class Request extends Collection
{
    protected $inputHandler;

    /**
     * Return all input data.
     *
     * @return Arrayable Input.
     */
    public function all($format = NULL)
    {
        if (!$this->inputHandler) {
            $this->inputHandler    = $this->getInputHandler();
            $this->items           = $this->inputHandler->get($this->getMethod());
        }

        return parent::all();
    }

    public function getInputHandler()
    {
        switch ($this->getContentType()) {
            case 'application/json':
                return new JsonInput;
                break;

            case 'multipart/form-data':
            case 'application/x-www-form-urlencoded':
                return new DefaultInput;
                break;

            default:
                return new DefaultInput;
                break;
        }
    }

    /**
     * Get the Content-Type header.
     *
     * @return string Content-Type header.
     */
    public function getContentType()
    {
        if (array_key_exists("CONTENT_TYPE", $_SERVER)) {
            $result = explode(';', $_SERVER["CONTENT_TYPE"], 2);

            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * Get the request method
     *
     * @return string Request Method.
     */
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
