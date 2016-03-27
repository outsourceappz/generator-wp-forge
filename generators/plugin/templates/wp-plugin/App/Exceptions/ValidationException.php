<?php
namespace <%- props.appName %>\Exceptions;

use Exception;

class ValidationException extends Exception
{
    protected $validator;

    public function __construct($validator)
    {
        parent::__construct('Validation Exception', 422);
        $this->validator = $validator;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function errors()
    {
        return $this->validator->errors();
    }
}
