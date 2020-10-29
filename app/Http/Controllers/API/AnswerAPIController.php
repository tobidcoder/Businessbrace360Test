<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAnswerAPIRequest;
use App\Http\Requests\API\UpdateAnswerAPIRequest;
use App\Models\Answer;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AnswerController
 * @package App\Http\Controllers\API
 */

class AnswerAPIController extends AppBaseController
{
    /** @var  AnswerRepository */
    private $answerRepository;

    public function __construct(AnswerRepository $answerRepo)
    {
        $this->answerRepository = $answerRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @OA\Get(
     *      path="/answers",
     *      summary="Get a listing of the Answers.",
     *      tags={"Answer"},
     *      description="Get all Answers",
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
     *                  @OA\Items(ref="#/components/schemas/Answer")
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
        $answers = $this->answerRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($answers->toArray(), 'Answers retrieved successfully');
    }

    /**
     * @param CreateAnswerAPIRequest $request
     * @return Response
     *
     * @OA\Post(
     *      path="/answers",
     *      summary="Store a newly created Answer in storage",
     *      tags={"Answer"},
     *      description="Store Answer",
     *      @OA\RequestBody(
     *          description="Answer that should be stored",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/Answer")
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
     *                  ref="#/components/schemas/Answer"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAnswerAPIRequest $request)
    {
        $input = $request->all();

        $answer = $this->answerRepository->create($input);

        return $this->sendResponse($answer->toArray(), 'Answer saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Get(
     *      path="/answers/{id}",
     *      summary="Display the specified Answer",
     *      tags={"Answer"},
     *      description="Get Answer",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Answer",
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
     *                  ref="#/components/schemas/Answer"
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
        /** @var Answer $answer */
        $answer = $this->answerRepository->find($id);

        if (empty($answer)) {
            return $this->sendError('Answer not found');
        }

        return $this->sendResponse($answer->toArray(), 'Answer retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAnswerAPIRequest $request
     * @return Response
     *
     * @OA\Put(
     *      path="/answers/{id}",
     *      summary="Update the specified Answer in storage",
     *      tags={"Answer"},
     *      description="Update Answer",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Answer",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          description="Answer that should be updated",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/Answer")
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
     *                  ref="#/components/schemas/Answer"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAnswerAPIRequest $request)
    {
        $input = $request->all();

        /** @var Answer $answer */
        $answer = $this->answerRepository->find($id);

        if (empty($answer)) {
            return $this->sendError('Answer not found');
        }

        $answer = $this->answerRepository->update($input, $id);

        return $this->sendResponse($answer->toArray(), 'Answer updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Delete(
     *      path="/answers/{id}",
     *      summary="Remove the specified Answer from storage",
     *      tags={"Answer"},
     *      description="Delete Answer",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Answer",
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
        /** @var Answer $answer */
        $answer = $this->answerRepository->find($id);

        if (empty($answer)) {
            return $this->sendError('Answer not found');
        }

        $answer->delete();

        return $this->sendSuccess('Answer deleted successfully');
    }
}
