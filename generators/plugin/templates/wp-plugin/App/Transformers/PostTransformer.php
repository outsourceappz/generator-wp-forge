<?php
namespace <%- props.appName %>\Transformers;

use <%- props.appName %>\Core\WP\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer  extends TransformerAbstract
{

    /**
     * List of available includes
     *
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * Transform function
     *
     * @param <%- props.appName %>\Models\Post $resource Eloquent Model
     *
     * @return array
     */
    public function transform(Post $resource)
    {
        return [
            'ID'           => (integer) $resource->ID,
            'post_title'   => $resource->post_title,
            'post_content' => $resource->post_content,
            'post_status'  => $resource->post_status,

        ];
    }
}
