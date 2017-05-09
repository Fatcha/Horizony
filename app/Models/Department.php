<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Department extends Model {
    protected $table = 'departments';

    public function users() {
        return $this->hasMany(User::class,'department_id');
    }

}
