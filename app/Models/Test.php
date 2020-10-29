<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      schema="Test",
 *      required={"question", "answer", "grade", "job_id"},  
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          format="int32",
 *          description="id"
 *      ),
 *      @OA\Property(
 *          property="question",
 *          type="string",
 *          description="question"
 *      ),
 *      @OA\Property(
 *          property="answer",
 *          type="string",
 *          description="answer"
 *      ),
 *      @OA\Property(
 *          property="grade",
 *          type="string",
 *          description="grade"
 *      ),
 *      @OA\Property(
 *          property="job_id",
 *          type="integer",
 *          format="int32",
 *          description="job_id"
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
class Test extends Model
{
    use SoftDeletes;

    public $table = 'tests';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'question',
        'answer',
        'grade',
        'job_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'question' => 'string',
        'answer' => 'string',
        'grade' => 'string',
        'job_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'question' => 'required|string',
        'answer' => 'required|string|max:255',
        'grade' => 'required|string|max:255',
        'job_id' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
