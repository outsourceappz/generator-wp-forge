<?php

namespace <%- props.appName %>\Core\Input;

class JsonInput implements InputInterface
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
                return array_merge($_GET, json_decode(file_get_contents("php://input"), true));
                break;

            default:
                # code...
                break;
        }
    }
}
