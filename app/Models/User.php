<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'role_id' => null,
        'suspended' => 0,
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_id', 'username', 'email', 'password',];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.  (i think it only works for array and json serialization so accessor and mutator is needed )
     *
     * @var array
     */
    protected $casts = [
        'suspended' => 'boolean',
    ];
    
    public function role(){
        return $this->belongsTo(Role::class);
    }
}
