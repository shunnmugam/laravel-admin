<?php

namespace cms\core\user\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table='users';

    protected $hidden = ['password'];

    public function group()
    {

        return $this->belongsToMany('cms\core\usergroup\Models\UserGroupModel',
            'user_group_map', 'user_id', 'group_id');

            //->withPivot([ ARRAY OF FIELDS YOU NEED FROM meta TABLE ]);
        //return $this->hasManyThrough('cms\core\usergroup\Models\UserGroupModel','cms\core\usergroup\Models\UserGroupMapModel',
           // 'user_id','id','id');
    }
    public function groupMap()
    {
        return $this->hasMany('cms\core\usergroup\Models\UserGroupMapModel','user_id','id');
    }
}
