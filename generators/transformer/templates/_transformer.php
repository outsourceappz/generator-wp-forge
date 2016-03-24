<?php
namespace <%- props.namespace %>\Transformers;

use <%- props.namespace %>\Models\<%- props.className %>;
use League\Fractal\TransformerAbstract;

class <%- props.className %>Transformer  extends TransformerAbstract
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
     * @param <%- props.namespace %>\Models\<%- props.className %> $resource Eloquent Model
     *
     * @return array
     */
    public function transform(<%- props.className %> $resource)
    {
        return [
            'id'           => (integer) $resource->id,<% for(var i = 0; i < props.fieldNames.length; i++) {%>
            '<%-  props.fieldNames[i]  %>' => $resource-><%-  props.fieldNames[i]  %>,<% } %>
        ];
    }
}
