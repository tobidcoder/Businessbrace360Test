<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      schema="Job",
 *      required={"title", "description", "qualification", "employment_type", "job_function", "jobs_status"},  
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          format="int32",
 *          description="id"
 *      ),
 *      @OA\Property(
 *          property="title",
 *          type="string",
 *          description="title"
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          description="description"
 *      ),
 *      @OA\Property(
 *          property="responsibility",
 *          type="string",
 *          description="responsibility"
 *      ),
 *      @OA\Property(
 *          property="qualification",
 *          type="string",
 *          description="qualification"
 *      ),
 *      @OA\Property(
 *          property="remuneration",
 *          type="number",
 *          format="number",
 *          description="remuneration"
 *      ),
 *      @OA\Property(
 *          property="employment_type",
 *          type="string",
 *          description="employment_type"
 *      ),
 *      @OA\Property(
 *          property="job_function",
 *          type="string",
 *          description="job_function"
 *      ),
 *      @OA\Property(
 *          property="industry",
 *          type="string",
 *          description="industry"
 *      ),
 *      @OA\Property(
 *          property="seniority_level",
 *          type="string",
 *          description="seniority_level"
 *      ),
 *      @OA\Property(
 *          property="pay_range",
 *          type="string",
 *          description="pay_range"
 *      ),
 *      @OA\Property(
 *          property="jobs_status",
 *          type="string",
 *          description="jobs_status"
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
class Job extends Model
{
    use SoftDeletes;

    public $table = 'jobs';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'description',
        'responsibility',
        'qualification',
        'remuneration',
        'employment_type',
        'job_function',
        'industry',
        'seniority_level',
        'pay_range',
        'jobs_status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'responsibility' => 'string',
        'qualification' => 'string',
        'remuneration' => 'decimal:2',
        'employment_type' => 'string',
        'job_function' => 'string',
        'industry' => 'string',
        'seniority_level' => 'string',
        'pay_range' => 'string',
        'jobs_status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'responsibility' => 'nullable|string|max:255',
        'qualification' => 'required|string|max:255',
        'remuneration' => 'nullable|numeric',
        'employment_type' => 'required|string|max:255',
        'job_function' => 'required|string|max:255',
        'industry' => 'nullable|string|max:255',
        'seniority_level' => 'nullable|string|max:255',
        'pay_range' => 'nullable|string|max:255',
        'jobs_status' => 'required|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
