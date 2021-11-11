<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $appends = ['user_roles', 'fullname'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'surname',
        'username',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getUserRolesAttribute()
    {

        return $this->roles()->pluck('name')->toArray();
    }

    public function getFullnameAttribute()
    {

        return $this->name . ' ' . $this->surname;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
