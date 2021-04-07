<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
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
    protected $fillable = ['username', 'email', 'password',];

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
	
	public function scopeUsername($query, $username){
		return $query->where('username', $username);
	}
    
    public function role(){
        return $this->belongsTo(Role::class);
    }
	
	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier(){
		return $this->getKey();
	}
	
	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims(){
		return [];
	}
}
