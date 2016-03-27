<?php
namespace <%- props.appName %>;

class Plugin
{

    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function run()
    {
        add_action( 'init', array($this, 'i18n' ) );
        add_action( 'init', array($this, 'init' ) );
    }

    function i18n()
    {
        $locale = apply_filters( 'plugin_locale', get_locale(), '<%- props.pluginNameSanitized %>' );

        load_textdomain( '<%- props.pluginNameSanitized %>', WP_LANG_DIR . '/<%- props.pluginNameSanitized %>/<%- props.pluginNameSanitized %>-' . $locale . '.mo' );

        load_plugin_textdomain( '<%- props.pluginNameSanitized %>', false, plugin_basename( $this->container['path'] ) . '/languages/' );
    }

    /**
     * Initializes the plugin and fires an action other plugins can hook into.
     *
     * @uses do_action()
     *
     * @return void
     */
    function init()
    {
        do_action( '<%- props.pluginNameSanitized %>' );

        $router = $this->container['router'];
        require_once $this->container['base'] . '/routes.php';

        // dd($this->container['request']->all());
    }

    public function activate()
    {
        init();
        $this->container['migration']->run();
        flush_rewrite_rules();
    }

    function deactivate()
    {
    }
}
