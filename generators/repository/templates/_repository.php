<?php
namespace <%- props.namespace %>\Repositories;

use <%- props.namespace %>\Core\BaseRepository;
use <%- props.namespace %>\Models\<%- props.className %>;

class <%- props.className %>Repository extends BaseRepository
{
    public $primaryKey = 'id';

    public function makeModel()
    {
        return new <%- props.className %>;
    }

    public function createRules($attributes)
    {
        return [<% for(var i = 0; i < props.fieldNames.length; i++) {%>
            '<%-  props.fieldNames[i]  %>' => 'required',<% } %>
        ];
    }

    public function updateRules($attributes, $id)
    {
        return [<% for(var i = 0; i < props.fieldNames.length; i++) {%>
            '<%-  props.fieldNames[i]  %>' => 'required',<% } %>
        ];
    }
}
