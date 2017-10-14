<?php

namespace cms\core\blog\Models;

use Illuminate\Database\Eloquent\Model;


//trait
use cms\core\search\traits\Searchable;
class BlogModel extends Model
{

    use Searchable;


    public $searchable = ['id',
        'title',
        'content',
        'created_at',
        'updated_at'];

    protected $table = 'blog';

    public function category()
    {
        return $this->belongsTo('cms\core\blog\Models\BlogCategoryModel','category_id','id');
    }

    public function next()
    {
       return  $this->where('category_id','=',$this->category_id)
            ->where('id','>',$this->id)
           ->where('status','=',1)->first();
    }
    public function previous()
    {
       return  $this->where('category_id','=',$this->category_id)
            ->where('id','<',$this->id)
           ->where('status','=',1)->first();
    }

    public function related()
    {
        return  $this->where('category_id','=',$this->category_id)
            ->where('id','!=',$this->id)
            ->where('status','=',1)->get();
    }
}
