<?php

namespace App\Repositories;

use App\Models\SuccessfulCandidate;
use App\Repositories\BaseRepository;

/**
 * Class SuccessfulCandidateRepository
 * @package App\Repositories
 * @version October 30, 2020, 8:38 am WAT
*/

class SuccessfulCandidateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'job_id',
        'candidate_id',
        'pass_mark',
        'employed'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SuccessfulCandidate::class;
    }
}
