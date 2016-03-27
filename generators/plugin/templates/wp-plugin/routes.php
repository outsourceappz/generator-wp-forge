<?php

    $post_api = new \<%- props.appName %>\Http\Controllers\API\Post($this->container);

    $router->admin_resource('posts', $post_api);
    $router->public_resource('posts', $post_api);
