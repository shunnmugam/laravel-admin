<?php

namespace cms\core\menu\Models;

use Illuminate\Database\Eloquent\Model;

class AdminMenuGroupModel extends Model
{
    protected $table = 'admin_menu_group';

    public function menu()
    {
        return $this->hasMany('cms\core\menu\Models\AdminMenuModel','group_id','id');
    }

    public function menugroup()
    {
        return $this->hasMany('cms\core\menu\Models\AdminMenuGroupModel','parent','id');
    }
}
