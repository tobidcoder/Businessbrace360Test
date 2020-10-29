<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      schema="Answer",
 *      required={"question_id", "candidate_id", "answers"},  
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          format="int32",
 *          description="id"
 *      ),
 *      @OA\Property(
 *          property="question_id",
 *          type="integer",
 *          format="int32",
 *          description="question_id"
 *      ),
 *      @OA\Property(
 *          property="candidate_id",
 *          type="integer",
 *          format="int32",
 *          description="candidate_id"
 *      ),
 *      @OA\Property(
 *          property="answers",
 *          type="string",
 *          description="answers"
 *      ),
 *      @OA\Property(
 *          property="marks",
 *          type="string",
 *          description="marks"
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
class Answer extends Model
{
    use SoftDeletes;

    public $table = 'answers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'question_id',
        'candidate_id',
        'answers',
        'marks'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'question_id' => 'integer',
        'candidate_id' => 'integer',
        'answers' => 'string',
        'marks' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'question_id' => 'required',
        'candidate_id' => 'required',
        'answers' => 'required|string',
        'marks' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
