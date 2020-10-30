<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * @OA\Schema(
 *      schema="Admin",
 *      required={"email", "username", "first_name", "last_name", "password"},  
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          format="int32",
 *          description="id"
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          description="email"
 *      ),
 *      @OA\Property(
 *          property="username",
 *          type="string",
 *          description="username"
 *      ),
 *      @OA\Property(
 *          property="first_name",
 *          type="string",
 *          description="first_name"
 *      ),
 *      @OA\Property(
 *          property="last_name",
 *          type="string",
 *          description="last_name"
 *      ),
 *      @OA\Property(
 *          property="password",
 *          type="string",
 *          description="password"
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          type="string",
 *          format="date-time",
 *          description="created_at"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          type="string",
 *          format="date-time",
 *          description="updated_at"
 *      )    
 * )
 */
class Admin extends Authenticatable
{
    use HasApiTokens;

    public $table = 'admins';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'email',
        'username',
        'first_name',
        'last_name',
        'password'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'email' => 'string',
        'username' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'password' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'email' => 'required|string|max:255',
        'username' => 'required|string|max:255',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'password' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
