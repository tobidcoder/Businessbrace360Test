<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSuccessfulCandidateAPIRequest;
use App\Http\Requests\API\UpdateSuccessfulCandidateAPIRequest;
use App\Models\SuccessfulCandidate;
use App\Repositories\SuccessfulCandidateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SuccessfulCandidateController
 * @package App\Http\Controllers\API
 */

class SuccessfulCandidateAPIController extends AppBaseController
{
    /** @var  SuccessfulCandidateRepository */
    private $successfulCandidateRepository;

    public function __construct(SuccessfulCandidateRepository $successfulCandidateRepo)
    {
        $this->successfulCandidateRepository = $successfulCandidateRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @OA\Get(
     *      path="/successfulCandidates",
     *      summary="Get a listing of the SuccessfulCandidates.",
     *      tags={"SuccessfulCandidate"},
     *      description="Get all SuccessfulCandidates",
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
     *                  @OA\Items(ref="#/components/schemas/SuccessfulCandidate")
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
        $successfulCandidates = $this->successfulCandidateRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($successfulCandidates->toArray(), 'Successful Candidates retrieved successfully');
    }

    /**
     * @param CreateSuccessfulCandidateAPIRequest $request
     * @return Response
     *
     * @OA\Post(
     *      path="/successfulCandidates",
     *      summary="Store a newly created SuccessfulCandidate in storage",
     *      tags={"SuccessfulCandidate"},
     *      description="Store SuccessfulCandidate",
     *      @OA\RequestBody(
     *          description="SuccessfulCandidate that should be stored",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/SuccessfulCandidate")
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
     *                  ref="#/components/schemas/SuccessfulCandidate"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSuccessfulCandidateAPIRequest $request)
    {
        $input = $request->all();

        $successfulCandidate = $this->successfulCandidateRepository->create($input);

        return $this->sendResponse($successfulCandidate->toArray(), 'Successful Candidate saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Get(
     *      path="/successfulCandidates/{id}",
     *      summary="Display the specified SuccessfulCandidate",
     *      tags={"SuccessfulCandidate"},
     *      description="Get SuccessfulCandidate",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of SuccessfulCandidate",
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
     *                  ref="#/components/schemas/SuccessfulCandidate"
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
        /** @var SuccessfulCandidate $successfulCandidate */
        $successfulCandidate = $this->successfulCandidateRepository->find($id);

        if (empty($successfulCandidate)) {
            return $this->sendError('Successful Candidate not found');
        }

        return $this->sendResponse($successfulCandidate->toArray(), 'Successful Candidate retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSuccessfulCandidateAPIRequest $request
     * @return Response
     *
     * @OA\Put(
     *      path="/successfulCandidates/{id}",
     *      summary="Update the specified SuccessfulCandidate in storage",
     *      tags={"SuccessfulCandidate"},
     *      description="Update SuccessfulCandidate",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of SuccessfulCandidate",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          description="SuccessfulCandidate that should be updated",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/SuccessfulCandidate")
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
     *                  ref="#/components/schemas/SuccessfulCandidate"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSuccessfulCandidateAPIRequest $request)
    {
        $input = $request->all();

        /** @var SuccessfulCandidate $successfulCandidate */
        $successfulCandidate = $this->successfulCandidateRepository->find($id);

        if (empty($successfulCandidate)) {
            return $this->sendError('Successful Candidate not found');
        }

        $successfulCandidate = $this->successfulCandidateRepository->update($input, $id);

        return $this->sendResponse($successfulCandidate->toArray(), 'SuccessfulCandidate updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Delete(
     *      path="/successfulCandidates/{id}",
     *      summary="Remove the specified SuccessfulCandidate from storage",
     *      tags={"SuccessfulCandidate"},
     *      description="Delete SuccessfulCandidate",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of SuccessfulCandidate",
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
        /** @var SuccessfulCandidate $successfulCandidate */
        $successfulCandidate = $this->successfulCandidateRepository->find($id);

        if (empty($successfulCandidate)) {
            return $this->sendError('Successful Candidate not found');
        }

        $successfulCandidate->delete();

        return $this->sendSuccess('Successful Candidate deleted successfully');
    }
}
