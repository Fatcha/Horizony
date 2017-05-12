<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //

    public function tasks(){

        return $this->hasMany(Task::class, 'project_id');
    }
    public function company(){

        return $this->belongsTo(Company::class, 'company_id');
    }

    public function category(){

        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }
}
