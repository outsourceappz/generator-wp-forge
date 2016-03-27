<?php
namespace <%- props.appName %>\Repositories;

use <%- props.appName %>\Core\BaseRepository;
use <%- props.appName %>\Core\WP\Models\Post;

class PostRepository extends BaseRepository
{
    public $primaryKey = 'ID';

    public function makeModel()
    {
        return new Post;
    }

    public function createRules($attributes)
    {
        return ['post_title' => 'required'];
    }

    public function updateRules($attributes, $id)
    {
        return ['post_title' => 'required','post_content' => 'required'];
    }
}
