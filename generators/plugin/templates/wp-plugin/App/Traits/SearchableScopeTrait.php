<?php namespace <%- props.appName %>\Traits;

/**
 * Inspired from CakeDC's search plugin - https://github.com/CakeDC/search
 *
 * Add a scope query to Laravel's Eloquent Model.
 *
 * $filterArgs definitions in the Eloquent Model
 *
 */
trait SearchableScopeTrait
{
    public static function scopeSearch($query, $input)
    {
        $data =  array_only($input, array_keys(static::$filterArgs));

        // Build up the query object.
        foreach ($data as $key => $value) {
            // Ignore if the key is not present.
            if (!isset(static::$filterArgs[$key])) {
                continue;
            }

            // Ignore if no value.
            if (($value == null) || ($value === '')) {
                continue;
            }

            $filter = static::$filterArgs[$key];

            if (!isset($filter['field'])) {
                $filter['field'] = $key;
            }

            // Define value transformers
            // TODO: refactor out from here.
            if ($filter['operator'] == 'like') {
                $filter['transformer'] = function ($value) {
                    return "%" . $value . "%";
                };
            }

            if (isset($filter['transformer'])) {
                $value = $filter['transformer']($value);
            }

            $query->where($filter['field'], $filter['operator'], $value);
        }

        $query = static::scopeSort($query, $input);

        return $query;
    }

    public static function scopeSort($query, $input)
    {
        if (!isset($input['sort'])) {
            return $query;
        }

        $key = $input['sort'];

        if (!isset(static::$filterArgs[$key]) || !isset(static::$filterArgs[$key]['sort']) || !static::$filterArgs[$key]['sort']) {
            return $query;
        }

        $query->orderBy($key, isset($input['order_by']) ? $input['order_by'] : 'desc');

        return $query;
    }
}
