<?php

namespace cms\core\blog\Models;

use Illuminate\Database\Eloquent\Model;

class BlogModel extends Model
{
    protected $table = 'blog';

    public function category()
    {
        return $this->belongsTo('cms\core\blog\Models\BlogCategoryModel','category_id','id');
    }
}
