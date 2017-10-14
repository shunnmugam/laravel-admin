<?php
namespace  cms\core\search\traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

trait Searchable {
    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param array|null                         $defaultSortParameters
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeSearchable($query)
    {
        if (Request::has('search'))
        {
            return $this->querySearchBuilder($query);
        } else
        {
            return $query;
        }
    }
    /**
     * @param $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function querySearchBuilder($query)
    {
        $model = $this;
        $columns = DB::getSchemaBuilder()->getColumnListing($model->getTable());
        if (isset($model->searchable))
        {
            $columns = $model->searchable;
        }
        if(isset($model->ignoreSearchable) && is_array($model->ignoreSearchable)){
            foreach ($model->ignoreSearchable as $ignore){
                if(($key = array_search($ignore, $columns)) !== false){
                    unset($columns[$key]);
                }
            }
        }
        foreach ($columns as $column)
        {
            $query->orWhere($column, 'like', '%'.Request::get('search').'%');
        }
        return $query;
    }
}