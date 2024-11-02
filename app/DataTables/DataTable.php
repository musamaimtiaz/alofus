<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Millat <[millat.techvill@gmail.com]>
 *
 * @created 07-09-2021
 */

namespace App\DataTables;

use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Auth;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Relations\Relation as EloquentRelation;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Yajra\DataTables\Services\DataTable as BaseDataTable;

class DataTable extends BaseDataTable
{
    /**
     * prms
     *
     * @var mixed
     */
    public $prms;

    /**
     * preference
     *
     * @var mixed
     */
    public $preference;

    /**
     * addtitional data
     *
     * @var array
     */
    public $data = [];

    /**
     * dataTable
     *
     * @var object
     */
    public $dataTable;

    /**
     * builder
     *
     * @var object
     */
    public $builder;

    /*
    * DataTable Construct
    *
    * @return void
    */
    public function __construct()
    {
        $this->prms = Permission::getAuthUserPermission(optional(Auth::user())->id);
        $this->preference = preference();
        $this->dataTable = datatables()->of($this->query());
        $this->builder = $this->builder();
    }

    /*
    * Make Ajax
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function makeAjax(): JsonResponse
    {
        return apply_filters("{$this->filterTag()}@ajax", $this->dataTable)->make(true);
    }

    /*
    * Make Html
    *
    * @return \Yajra\DataTables\Html\Builder
    */
    public function makeHtml()
    {
        return apply_filters("{$this->filterTag()}@html", $this->builder);
    }

    /*
    * Apply Scopes
    *
    * @param \Illuminate\Database\Eloquent\Builder
    *   |\Illuminate\Database\Query\Builder
    *   |\Illuminate\Database\Eloquent\Relations\Relation
    *   |\Illuminate\Support\Collection
    *   |\Illuminate\Http\Resources\Json\AnonymousResourceCollection $query

    * @return \Illuminate\Database\Eloquent\Builder
    *   |\Illuminate\Database\Query\Builder
    *   |\Illuminate\Database\Eloquent\Relations\Relation
    *   |\Illuminate\Support\Collection
    *   |\Illuminate\Http\Resources\Json\AnonymousResourceCollection
    */
    protected function applyScopes(EloquentBuilder|QueryBuilder|EloquentRelation|Collection|AnonymousResourceCollection $query): EloquentBuilder|QueryBuilder|EloquentRelation|Collection|AnonymousResourceCollection
    {
        return parent::applyScopes(apply_filters("{$this->filterTag()}@query", $query));
    }

    /*
    * Filter Tag Name of the DataTable Class
    *
    * @return string
    */
    private function filterTag()
    {
        return get_class($this);
    }

    /*
    * Has Permission
    *
    * @param array $permissions
    * @return bool
    */
    public function hasPermission(array $permissions): bool
    {
        return (array_intersect($permissions, $this->prms)) ? true : false;
    }

    /*
     * Render the DataTable
     *
     * @param string $view
     * @param array $data
     * @param array $mergeData
     * @return mixed
     */
    public function render(?string $view = null, array $data = [], array $mergeData = [])
    {
        $this->setViewData();

        $mergedData = array_merge($this->data, $data);

        $params = apply_filters("{$this->filterTag()}@render", [$view, $mergedData, $mergeData]);

        return parent::render(...$params);
    }

    /*
     * Set Additional Data
     * To be implemented in child classes
     */
    protected function setViewData()
    {
        // To be implemented in child classes
    }
}
