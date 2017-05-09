<?php

namespace App;

use App\Models\Department;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const ACCESS_LEVEL_MEMBER = 'member';
    const ACCESS_LEVEL_ADMIN = 'admin';

    public function companies() {
        return $this->belongsToMany('App\Models\Company');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function avatar() {
        if($this->linkedInProfile){
            $avatar = $this->linkedInProfile->avatar;
            if(!empty($avatar)){
                return $avatar;
            }
            return false;
        }
        return false;
    }

    public function generateUrlConnexion() {
        $sha1Id = sha1($this->id);
        $sha1CryptedId = sha1($this->crypted_id);

        return route('connect_with_crypted_id', [$sha1Id, $sha1CryptedId]);
    }
    /**
     * Retrive a user by email address
     * @param $email
     * @return mixed
     */
    public static function getUserByEmail($email) {
        return User::where('email', $email)->first();
    }
}
