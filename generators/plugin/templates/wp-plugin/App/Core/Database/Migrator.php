<?php
namespace <%- props.appName %>\Core\Database;

class Migrator extends \Illuminate\Database\Migrations\Migrator
{

    public function __construct($repository, $db_resolver, $filesystem)
    {
        $this->repository = $repository;
        $this->resolver   = $db_resolver;
        $this->files      = $filesystem;
    }
}
