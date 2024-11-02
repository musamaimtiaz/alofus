<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Search extends Model
{
    use ModelTrait;

    /**
     * relation with userSearch table
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userSearch()
    {
        return $this->hasMany('App\Models\UserSearch', 'search_id', 'id');
    }

    /**
     * Store
     *
     * @param  array  $data
     * @return int|null
     */
    public function store($data = [])
    {
        if (isset($data['name'])) {
            $searchData = parent::where('name', $data['name']);

            if (! $searchData->exists()) {
                $id = parent::insertGetId(array_merge($data, ['updated_at' => Carbon::now()]));

                if (! empty($id)) {
                    return $id;
                }

                return false;
            } else {
                $searchData->first()->incrementTotal();

                return $searchData->first()->id;
            }
        }

        return false;
    }

    /**
     * Increase countdown
     *
     * @param  float  $amount
     * @return void
     */
    public function incrementTotal($data = 1)
    {
        $this->increment('total', $data);
    }

    public function getKeyword($keyword)
    {
        $data = ['status' => 0, 'message' => __('No record found')];

        if (isset(Auth::user()->id)) {
            $searchName = Search::WhereLike('name', strtolower($keyword))
                ->whereHas('userSearch', function ($q) {
                    $q->where('user_id', Auth::user()->id);
                })->orderBy('updated_at', 'DESC')->take(10)->pluck('name');
        } else {
            $searchName = Search::WhereLike('name', strtolower($keyword))
                ->whereHas('userSearch', function ($q) {
                    $q->where('browser_agent', getUniqueAddress());
                })->orderBy('updated_at', 'DESC')->take(10)->pluck('name');
        }

        if (! $searchName->isEmpty()) {
            $data = ['status' => 1, 'searchData' => json_encode($searchName)];
        }

        return $data;
    }
}
