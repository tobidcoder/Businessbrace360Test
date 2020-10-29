<?php

namespace App\Repositories;

use App\Models\Job;
use App\Repositories\BaseRepository;

/**
 * Class JobRepository
 * @package App\Repositories
 * @version October 29, 2020, 1:38 pm WAT
*/

class JobRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
        return Job::class;
    }
}
