<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      schema="JobApplicant",
 *      required={"job_id", "candidate_id"},  
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          format="int32",
 *          description="id"
 *      ),
 *      @OA\Property(
 *          property="job_id",
 *          type="integer",
 *          format="int32",
 *          description="job_id"
 *      ),
 *      @OA\Property(
 *          property="candidate_id",
 *          type="integer",
 *          format="int32",
 *          description="candidate_id"
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
class JobApplicant extends Model
{
//    use SoftDeletes;

    public $table = 'job_applicants';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'job_id',
        'candidate_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'job_id' => 'integer',
        'candidate_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'job_id' => 'required',
        'candidate_id' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
