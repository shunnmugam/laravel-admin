<?php

namespace cms\core\menu\Models;

use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    protected $table='menu';

    public function menuItems()
    {
        return $this->hasMany('cms\core\usergroup\Models\UserGroupMapModel','user_id','id');
    }
}
