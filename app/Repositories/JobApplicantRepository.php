<?php

namespace App\Repositories;

use App\Models\JobApplicant;
use App\Repositories\BaseRepository;

/**
 * Class JobApplicantRepository
 * @package App\Repositories
 * @version October 29, 2020, 1:39 pm WAT
*/

class JobApplicantRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'job_id',
        'candidate_id'
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
        return JobApplicant::class;
    }
}
