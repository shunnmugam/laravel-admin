<?php

namespace cms\core\module\Models;

use Illuminate\Database\Eloquent\Model;
use cms\core\gate\Models\PermissionModel;

class ModuleModel extends Model
{
   protected $table = 'modules';

   public function permissions()
   {
       return $this->hasMany('cms\core\gate\Models\PermissionModel','module_id','id');
   }
}
