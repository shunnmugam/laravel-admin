<?php

namespace cms\core\gate\Models;

use Illuminate\Database\Eloquent\Model;

class RolesModel extends Model
{
    protected $table = 'roles';

    public function module()
    {
        return $this->belongsTo('cms\core\module\Models\ModuleModel','module_id','id');
    }
}
