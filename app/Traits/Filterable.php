<?php

namespace App\Traits;

use Str;

trait Filterable
{
    public function scopeFilter($query, $param)
    {

        foreach ($param as $field => $value) {
            $method = 'filter' . Str::studly($field);
            if ($value === '') {
                continue;
            }


            if ($field == "search" && isset($this->searchable)) {
                foreach ($this->searchable as $key => $_value) {
                    if ($key === 0)
                        $query->where($this->table . '.' .  $_value, 'LIKE', '%' . $value . '%');
                    else
                        $query->orWhere($this->table . '.' .  $_value, 'LIKE', '%' . $value . '%');
                }
                continue;
            }

            if (method_exists($this, $method)) {
                $this->{$method}($query, $value);
                continue;
            }

            if (empty($this->filterable) || !is_array($this->filterable)) {
                continue;
            }


            if (in_array($field, $this->filterable)) {

                $query->where($field, $value);
                continue;
            }

            if (key_exists($field, $this->filterable)) {
                $query->where( $this->filterable[$field], $value);
                continue;
            }
        }

        return $query;
    }
}
