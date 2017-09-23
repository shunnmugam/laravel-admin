<?php

namespace cms\core\page\Models;

use Illuminate\Database\Eloquent\Model;

class PageModel extends Model
{
    protected $table='pages';


    public function group()
    {
        return $this->hasManyThrough('cms\core\usergroup\Models\UserGroupModel','cms\core\usergroup\Models\UserGroupMapModel',
            'group_id','id','id');
    }
    public function groupMap()
    {
        return $this->hasMany('cms\core\usergroup\Models\UserGroupMapModel','user_id','id');
    }
}
