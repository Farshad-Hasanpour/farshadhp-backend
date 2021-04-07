<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
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
	
	];
	
	/**
	 * The attributes that should be cast to native types.  (i think it only works for array and json serialization so accessor and mutator is needed )
	 *
	 * @var array
	 */
	protected $casts = [
	
	];
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    
    public function users(){
        return $this->hasMany(User::class);
    }
	
	public function is_administrator(){
    	return $this->id && $this->id === 1;
	}
}
