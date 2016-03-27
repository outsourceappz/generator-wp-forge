<?php
namespace <%- props.appName %>\Core;

class Router
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function public_resource($name, $api_object)
    {
        add_action( 'wp_ajax_nopriv_api_' . $name . '_index', [$api_object, 'index'] );
        add_action( 'wp_ajax_nopriv_api_' . $name . '_show', [$api_object, 'show'] );
        add_action( 'wp_ajax_nopriv_api_' . $name . '_store', [$api_object, 'store'] );
        add_action( 'wp_ajax_nopriv_api_' . $name . '_update', [$api_object, 'update'] );
        add_action( 'wp_ajax_nopriv_api_' . $name . '_destroy', [$api_object, 'destroy'] );
    }

    public function admin_resource($name, $api_object)
    {
        add_action( 'wp_ajax_api_' . $name . '_index', [$api_object, 'index'] );
        add_action( 'wp_ajax_api_' . $name . '_show', [$api_object, 'show'] );
    }
}
