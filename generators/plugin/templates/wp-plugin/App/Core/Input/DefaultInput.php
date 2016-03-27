<?php

namespace <%- props.appName %>\Core\Input;

class DefaultInput implements InputInterface
{

    public function get($method)
    {
        switch ($method) {
            case 'GET':
            case 'DELETE':

                return $_GET;
                break;

            case 'POST':
            case 'PUT':
                return array_merge($_GET, $_FILES, $_POST);
                break;

            default:
                # code...
                break;
        }
    }
}
