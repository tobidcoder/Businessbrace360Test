<?php

namespace App\Repositories;

use App\Models\Candidate;
use App\Repositories\BaseRepository;

/**
 * Class CandidateRepository
 * @package App\Repositories
 * @version October 29, 2020, 1:38 pm WAT
*/

class CandidateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'email',
        'username',
        'first_name',
        'last_name',
        'password',
        'address',
        'phone_number'
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
        return Candidate::class;
    }
}
