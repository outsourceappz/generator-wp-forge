<?php

namespace <%- props.appName %>\Core\WP\Models;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    protected $primaryKey = 'meta_id';

    public function getTable()
    {
        return $this->getConnection()->db->prefix . 'postmeta';
    }
}
