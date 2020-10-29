<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateJobApplicantAPIRequest;
use App\Http\Requests\API\UpdateJobApplicantAPIRequest;
use App\Models\JobApplicant;
use App\Repositories\JobApplicantRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class JobApplicantController
 * @package App\Http\Controllers\API
 */

class JobApplicantAPIController extends AppBaseController
{
    /** @var  JobApplicantRepository */
    private $jobApplicantRepository;

    public function __construct(JobApplicantRepository $jobApplicantRepo)
    {
        $this->jobApplicantRepository = $jobApplicantRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @OA\Get(
     *      path="/job_applicants",
     *      summary="Get a listing of the JobApplicants.",
     *      tags={"JobApplicant"},
     *      description="Get all JobApplicants",
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
     *                  @OA\Items(ref="#/components/schemas/JobApplicant")
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
        $jobApplicants = $this->jobApplicantRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($jobApplicants->toArray(), 'Job Applicants retrieved successfully');
    }

    /**
     * @param CreateJobApplicantAPIRequest $request
     * @return Response
     *
     * @OA\Post(
     *      path="/job_applicants",
     *      summary="Store a newly created JobApplicant in storage",
     *      tags={"JobApplicant"},
     *      description="Store JobApplicant",
     *      @OA\RequestBody(
     *          description="JobApplicant that should be stored",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/JobApplicant")
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
     *                  ref="#/components/schemas/JobApplicant"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateJobApplicantAPIRequest $request)
    {
        $input = $request->all();

        $jobApplicant = $this->jobApplicantRepository->create($input);

        return $this->sendResponse($jobApplicant->toArray(), 'Job Applicant saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Get(
     *      path="/job_applicants/{id}",
     *      summary="Display the specified JobApplicant",
     *      tags={"JobApplicant"},
     *      description="Get JobApplicant",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of JobApplicant",
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
     *                  ref="#/components/schemas/JobApplicant"
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
        /** @var JobApplicant $jobApplicant */
        $jobApplicant = $this->jobApplicantRepository->find($id);

        if (empty($jobApplicant)) {
            return $this->sendError('Job Applicant not found');
        }

        return $this->sendResponse($jobApplicant->toArray(), 'Job Applicant retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateJobApplicantAPIRequest $request
     * @return Response
     *
     * @OA\Put(
     *      path="/job_applicants/{id}",
     *      summary="Update the specified JobApplicant in storage",
     *      tags={"JobApplicant"},
     *      description="Update JobApplicant",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of JobApplicant",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          description="JobApplicant that should be updated",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/JobApplicant")
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
     *                  ref="#/components/schemas/JobApplicant"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateJobApplicantAPIRequest $request)
    {
        $input = $request->all();

        /** @var JobApplicant $jobApplicant */
        $jobApplicant = $this->jobApplicantRepository->find($id);

        if (empty($jobApplicant)) {
            return $this->sendError('Job Applicant not found');
        }

        $jobApplicant = $this->jobApplicantRepository->update($input, $id);

        return $this->sendResponse($jobApplicant->toArray(), 'JobApplicant updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Delete(
     *      path="/job_applicants/{id}",
     *      summary="Remove the specified JobApplicant from storage",
     *      tags={"JobApplicant"},
     *      description="Delete JobApplicant",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of JobApplicant",
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
        /** @var JobApplicant $jobApplicant */
        $jobApplicant = $this->jobApplicantRepository->find($id);

        if (empty($jobApplicant)) {
            return $this->sendError('Job Applicant not found');
        }

        $jobApplicant->delete();

        return $this->sendSuccess('Job Applicant deleted successfully');
    }
}
