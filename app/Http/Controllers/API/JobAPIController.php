<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateJobAPIRequest;
use App\Http\Requests\API\UpdateJobAPIRequest;
use App\Models\Job;
use App\Models\JobApplicant;
use App\Models\SuccessfulCandidate;
use App\Models\Test;
use App\Repositories\JobRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class JobController
 * @package App\Http\Controllers\API
 */

class JobAPIController extends AppBaseController
{
    /** @var  JobRepository */
    private $jobRepository;

    public function __construct(JobRepository $jobRepo)
    {
        $this->jobRepository = $jobRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @OA\Get(
     *      path="/jobs",
     *      summary="Get a listing of the Jobs.",
     *      tags={"Job"},
     *      description="Get all Jobs",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Job")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $jobs = $this->jobRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($jobs->toArray(), 'Jobs retrieved successfully');
    }

    /**
     * @param CreateJobAPIRequest $request
     * @return Response
     *
     * @OA\Post(
     *      path="/jobs",
     *      summary="Store a newly created Job in storage",
     *      tags={"Job"},
     *      description="Store Job",
     *      @OA\RequestBody(
     *          description="Job that should be stored",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/Job")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Job"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateJobAPIRequest $request)
    {
        $input = $request->all();

        $job = $this->jobRepository->create($input);

        return $this->sendResponse($job->toArray(), 'Job saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Get(
     *      path="/jobs/{id}",
     *      summary="Display the specified Job",
     *      tags={"Job"},
     *      description="Get Job",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Job",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Job"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Job $job */
        $job = $this->jobRepository->find($id);

        if (empty($job)) {
            return $this->sendError('Job not found');
        }

        return $this->sendResponse($job->toArray(), 'Job retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateJobAPIRequest $request
     * @return Response
     *
     * @OA\Put(
     *      path="/jobs/{id}",
     *      summary="Update the specified Job in storage",
     *      tags={"Job"},
     *      description="Update Job",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Job",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          description="Job that should be updated",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/Job")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Job"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateJobAPIRequest $request)
    {
        $input = $request->all();

        /** @var Job $job */
        $job = $this->jobRepository->find($id);

        if (empty($job)) {
            return $this->sendError('Job not found');
        }

        $job = $this->jobRepository->update($input, $id);

        return $this->sendResponse($job->toArray(), 'Job updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Delete(
     *      path="/jobs/{id}",
     *      summary="Remove the specified Job from storage",
     *      tags={"Job"},
     *      description="Delete Job",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Job",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Job $job */
        $job = $this->jobRepository->find($id);

        if (empty($job)) {
            return $this->sendError('Job not found');
        }

        $job->delete();

        return $this->sendSuccess('Job deleted successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Get(
     *      path="/test-for-jobs/{id}",
     *      summary="Display Test for a Job",
     *      tags={"Job"},
     *      description="Get Test for a Job",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Job",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Job"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function GetTestForJobs($id){
       $tests = Test::where('job_id', '=', $id)->get();
       if($tests){
           return $this->sendResponse($tests, 'Test for jobs, get successful', 'BT006');
       }
       return $this->sendError('Error', 'Something went wrong, when getting tst for jobs');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Get(
     *      path="/list-of-applicant-for-jobs/{id}",
     *      summary="Display List of applicant for a Job",
     *      tags={"Job"},
     *      description="Get List of Applicants for a Job",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Job",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Job"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function GetListOfApplicantsForAJobs($id){
        $tests = JobApplicant::where('job_id', '=', $id)->get();
        if($tests){
            return $this->sendResponse($tests, 'List of Applicant for a job, get successful', 'BT007');
        }
        return $this->sendError('Error', 'Something went wrong, when getting list of applicant for a job');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Get(
     *      path="/list-success-candidate-for-a-job/{id}",
     *      summary="Display List of successful candidate for a Job",
     *      tags={"Job"},
     *      description="Get List of successful candidate for a Job",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Job",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Job"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function GetListOfSuccessfulCandidateForAJobs($id){
        $tests = SuccessfulCandidate::where('job_id', '=', $id)->get();
        if($tests){
            return $this->sendResponse($tests, 'List of successful candidate for a job, get successful', 'BT008');
        }
        return $this->sendError('Error', 'Something went wrong, when getting list of successful candidate for a job');
    }
}
