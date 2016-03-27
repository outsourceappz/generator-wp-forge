<?php

namespace <%- props.appName %>;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Dependancy Injection Container.
 */
class Container extends \Pimple\Container
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->initialize();
        $this->initialize_components();
    }

    protected function initialize()
    {
        // Closure for resolving paginator current page number.
        \Illuminate\Pagination\Paginator::currentPageResolver(function ($default = 1) {
            if (isset($_REQUEST['page'])) {
                return $_REQUEST['page'];
            }

            return $default;
        });
    }

    /**
     * Register core features - database,
     *
     * @return void
     */
    protected function initialize_components()
    {
        $this['db'] = function () {
            global $wpdb;

            return $wpdb;
        };

        $this['capsule'] = function ($container) {
            return new Capsule;
        };

        $this['boot_eloquent'] = function ($container) {
            $collate = DB_CHARSET . '_general_ci';

            if (!empty(DB_COLLATE)) {
                $collate = DB_COLLATE;
            }

            $container['capsule']->addConnection(array(
                'driver'    => 'mysql',
                'host'      => DB_HOST,
                'database'  => DB_NAME,
                'username'  => DB_USER,
                'password'  => DB_PASSWORD,
                'charset'   => DB_CHARSET,
                'collation' => $collate,
                'prefix'    => $container['db']->prefix,
            ));

            // Make this Capsule instance available globally via static methods... (optional)
            $container['capsule']->setAsGlobal();

            // Setup the Eloquent ORM... (optional)
            $container['capsule']->bootEloquent();
        };

        $this['filesystem'] = function ($container) {
            return new Core\FileSystem;
        };

        $this['db_resolver'] = function ($container) {
            return new \<%- props.appName %>\Core\Database\Eloquent\Resolver;
        };

        $this['request'] = function ($container) {
            return new \<%- props.appName %>\Core\Request;
        };

        $this['migration_table'] = function ($container) {
            return 'my_migrations_table';
        };

        $this['migration'] = function ($container) {
            return new \<%- props.appName %>\Core\Database\MigrationManager($container);
        };

        $this['router'] = function ($container) {
            return new \<%- props.appName %>\Core\Router($container);
        };

        $this['validator'] = function ($container) {
            return new \<%- props.appName %>\Core\ValidatorFactory($container);
        };
    }

    /**
     * Variable setter
     *
     * @param [type] $key   [description]
     * @param [type] $value [description]
     */
    public function set($key, $value)
    {
        $this[$key] = function ($container) use (&$value) {
            return $value;
        };
    }

    public function base_path($path)
    {
        return $this['path'] . $path;
    }
}
