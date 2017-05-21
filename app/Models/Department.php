<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Department extends Model {
    protected $table = 'departments';

//    public function users() {
//        return $this->hasMany(User::class,'department_id');
//    }

    public function users() {
        return $this->belongsToMany('App\User','company_user')
            ->withPivot('role')
            ->orderBy('view_weight', 'asc')
            ->orderBy('users.name', 'asc');
       // return $this->belongsToMany('App\User')->withPivot('role');
    }

    public static function getDepartmentFromCompany($company_id){
        return Department::where('company_id','=',$company_id)->get();
    }

}
