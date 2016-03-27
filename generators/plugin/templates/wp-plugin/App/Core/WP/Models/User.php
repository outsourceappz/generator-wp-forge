<?php

namespace <%- props.appName %>\Core\WP\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $primaryKey = 'ID';
    protected $timestamp  = false;

    public function meta()
    {
        return $this->hasMany('<%- props.appName %>\Core\WP\Models\UserMeta', 'user_id');
    }
}
