<?php
/**
 * Plugin Name: <%- props.pluginName %>
 * Plugin URI:  <%- props.pluginURI %>
 * Description: <%- props.pluginDescription %>
 * Version:     <%- props.pluginVersion %>
 * Author:      <%- props.author %>
 * Author URI:  <%- props.authorURI %>
 * License:     GPLv2+
 * Text Domain: <%- props.pluginNameSanitized %>
 * Domain Path: /languages
 */

/**
 * Copyright (c) <%- props.currentYear %> <%- props.author %> (email : <%- props.email %>)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  <%- props.pluginVersion %>-1301  USA
 */

/**
 * Built using yo wp-forge:plugin
 * Copyright (c) <%- props.currentYear %> outsource appz.
 * https://github.com/outsourceappz/generator-wp-forge
 */

// Include files
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Var Dumper
 */
if (!function_exists('dd')) {
    function dd()
    {
        $args = func_get_args();
        call_user_func_array('dump', $args);
        die();
    }
}

$container = new \<%- props.appName %>\Container;

// Useful global constants
$container->set('version', '<%- props.pluginVersion %>');
$container->set('url',  plugin_dir_url( __FILE__ ));
$container->set('path', dirname( __FILE__ ) . '/' );
$container->set('base', __DIR__);

// Setup Eloquent ORM
$container['boot_eloquent'];

$plugin = new \<%- props.appName %>\Plugin($container);

// Activation/Deactivation
register_activation_hook( __FILE__, array($plugin, 'activate'));
register_deactivation_hook( __FILE__, array($plugin, 'deactivate'));

$plugin->run();
