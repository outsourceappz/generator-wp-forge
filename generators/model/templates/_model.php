<?php

namespace <%- props.namespace %>\Core\WP\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 *
 * @package WeDevs\ORM\WP
 */
class <%= props.className %> extends Model
{
    public $table = '<%- props.tableName %>';

    public $fillable = ['<%-  props.fieldNames.join("\',\'")%>'];
}
