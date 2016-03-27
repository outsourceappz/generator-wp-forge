<?php

namespace <%- props.appName %>\Core\Database;

use Exception;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;

class MigrationManager
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function run()
    {
        $repository = new DatabaseMigrationRepository($this->container['capsule']->getDatabaseManager(), $this->container['migration_table']);

        if (!$repository->repositoryExists()) {
            try {
                $repository->createRepository();
            } catch (\Exception $e) {
            }
        }

        $migrator = new Migrator($repository, $this->container['db_resolver'], $this->container['filesystem']);

        try {
            $migrator->run($this->container->base_path('database/migrations'));
        } catch (Exception $e) {
            // echo $e->getMessage();
        }
    }

    public function rollback()
    {
        $repository = new DatabaseMigrationRepository($this->container['capsule']->getDatabaseManager(), $this->container['migration_table']);

        try {
            if (!$repository->repositoryExists()) {
                $repository->createRepository();
            }
        } catch (\Exception $e) {
        }

        $filesystem = new Filesystem();
        $migrator   = new Migrator(
                                    $repository,
                                    $this->container['capsule']->getDatabaseManager(),
                                    $this->container['filesystem']
                                );

        $files = $this->container['filesystem']->files($path);

        foreach ($files as $file) {
            require_once $file;
        }

        // run rollback on all migrations
        while ($migrator->rollback()) {
        }

        $capsule = $this->container['capsule'];

        // delete the migrations table as well
        $capsule::schema()->drop($this->container['migration_table']);
    }
}
