<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      schema="SuccessfulCandidate",
 *      required={"job_id", "candidate_id", "pass_mark", "employed"},  
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
 *          property="pass_mark",
 *          type="integer",
 *          format="int32",
 *          description="pass_mark"
 *      ),
 *      @OA\Property(
 *          property="employed",
 *          type="string",
 *          description="employed"
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
class SuccessfulCandidate extends Model
{
    use SoftDeletes;

    public $table = 'successful_candidates';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'job_id',
        'candidate_id',
        'pass_mark',
        'employed'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'job_id' => 'integer',
        'candidate_id' => 'integer',
        'pass_mark' => 'integer',
        'employed' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'job_id' => 'required',
        'candidate_id' => 'required',
        'pass_mark' => 'required',
        'employed' => 'required|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
