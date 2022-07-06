<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait AppModelPaginate
{
    public function scopeCustomPaginate(Builder $query): Builder
    {
        $offset = request()->query
            ->get('offset', 0);

        $limit = request()->query
            ->get('limit', 50);

        throw_if(
            $limit > 1000,
            Exception::class,
            __('base.more_than_1000')
        );

        request()->collect('order')
            ->each(function ($direction, $field) use ($query) {
                throw_unless(
                    in_array(strtoupper($direction), ['ASC', 'DESC']),
                    Exception::class,
                    __('base.order_invalid_direction', compact('direction'))
                );

                throw_unless(
                    Schema::hasColumn($query->getModel()->getTable(), $field),
                    Exception::class,
                    __('base.order_invalid_field', compact('field'))
                );

                $query->orderBy($field, $direction);
            });

        return $query->offset($offset)
            ->limit($limit);
    }
}
