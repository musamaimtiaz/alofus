<?php

namespace App\Traits\ModelTraits;

trait EloquentHelper
{
    /**
     * findOrBack
     *
     * @param  mixed  $id
     * @param  mixed  $message
     * @return void
     */
    public static function findOrBack($id, $message = null)
    {
        if (! is_null($data = self::find($id))) {
            return $data;
        }

        \Session::flash('fail', ! is_null($message) ? $message : __('Opps! Data not found.'));

        return \Redirect::to(url()->previous())->send();
    }

    /**
     * findOrNot
     *
     * @param  mixed  $id
     * @return void
     */
    public static function findOrNot($id)
    {
        if (! is_null($data = self::find($id))) {
            return $data;
        }

        return false;
    }

    /**
     * WHERE $column LIKE %$value% query.
     *
     * @param  string  $boolean
     * @return mixed
     */
    public function scopeWhereLike($query, $column, $value, $boolean = 'and')
    {
        return $query->where($column, 'LIKE', "%$value%", $boolean);
    }

    /**
     * WHERE $column LIKE $value% query.
     *
     * @param  string  $boolean
     * @return mixed
     */
    public function scopeWhereBeginsWith($query, $column, $value, $boolean = 'and')
    {
        return $query->where($column, 'LIKE', "$value%", $boolean);
    }

    /**
     * WHERE $column LIKE %$value query.
     *
     * @param  string  $boolean
     * @return mixed
     */
    public function scopeWhereEndsWith($query, $column, $value, $boolean = 'and')
    {
        return $query->where($column, 'LIKE', "%$value", $boolean);
    }

    /**
     * orWhere $column LIKE %$value% query.
     *
     * @param  string  $boolean
     * @return mixed
     */
    public function scopeOrWhereLike($query, $column, $value, $boolean = 'and')
    {
        return $query->orWhere($column, 'LIKE', "%$value%", $boolean);
    }

    /**
     * orWhere $column LIKE $value% query.
     *
     * @param  string  $boolean
     * @return mixed
     */
    public function scopeOrWhereBeginsWith($query, $column, $value, $boolean = 'and')
    {
        return $query->orWhere($column, 'LIKE', "$value%", $boolean);
    }

    /**
     * orWhere $column LIKE %$value query.
     *
     * @param  string  $boolean
     * @return mixed
     */
    public function scopeOrWhereEndsWith($query, $column, $value, $boolean = 'and')
    {
        return $query->orWhere($column, 'LIKE', "%$value", $boolean);
    }

    /**
     * Select active records.
     *
     * @return Builder
     */
    public function scopeActive($query, $column = 'status')
    {
        return $query->where($column, 'Active');
    }

    /**
     * Select inactive records.
     *
     * @return Builder
     */
    public function scopeInactive($query, $column = 'status')
    {
        return $query->where($column, 'Inactive');
    }
}
