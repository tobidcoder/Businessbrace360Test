<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTestAPIRequest;
use App\Http\Requests\API\UpdateTestAPIRequest;
use App\Models\Test;
use App\Repositories\TestRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class TestController
 * @package App\Http\Controllers\API
 */

class TestAPIController extends AppBaseController
{
    /** @var  TestRepository */
    private $testRepository;

    public function __construct(TestRepository $testRepo)
    {
        $this->testRepository = $testRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @OA\Get(
     *      path="/tests",
     *      summary="Get a listing of the Tests.",
     *      tags={"Test"},
     *      description="Get all Tests",
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
     *                  @OA\Items(ref="#/components/schemas/Test")
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
        $tests = $this->testRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($tests->toArray(), 'Tests retrieved successfully');
    }

    /**
     * @param CreateTestAPIRequest $request
     * @return Response
     *
     * @OA\Post(
     *      path="/tests",
     *      summary="Store a newly created Test in storage",
     *      tags={"Test"},
     *      description="Store Test",
     *      @OA\RequestBody(
     *          description="Test that should be stored",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/Test")
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
     *                  ref="#/components/schemas/Test"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTestAPIRequest $request)
    {
        $input = $request->all();

        $test = $this->testRepository->create($input);

        return $this->sendResponse($test->toArray(), 'Test saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Get(
     *      path="/tests/{id}",
     *      summary="Display the specified Test",
     *      tags={"Test"},
     *      description="Get Test",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Test",
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
     *                  ref="#/components/schemas/Test"
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
        /** @var Test $test */
        $test = $this->testRepository->find($id);

        if (empty($test)) {
            return $this->sendError('Test not found');
        }

        return $this->sendResponse($test->toArray(), 'Test retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateTestAPIRequest $request
     * @return Response
     *
     * @OA\Put(
     *      path="/tests/{id}",
     *      summary="Update the specified Test in storage",
     *      tags={"Test"},
     *      description="Update Test",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Test",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          description="Test that should be updated",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/Test")
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
     *                  ref="#/components/schemas/Test"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTestAPIRequest $request)
    {
        $input = $request->all();

        /** @var Test $test */
        $test = $this->testRepository->find($id);

        if (empty($test)) {
            return $this->sendError('Test not found');
        }

        $test = $this->testRepository->update($input, $id);

        return $this->sendResponse($test->toArray(), 'Test updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Delete(
     *      path="/tests/{id}",
     *      summary="Remove the specified Test from storage",
     *      tags={"Test"},
     *      description="Delete Test",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Test",
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
        /** @var Test $test */
        $test = $this->testRepository->find($id);

        if (empty($test)) {
            return $this->sendError('Test not found');
        }

        $test->delete();

        return $this->sendSuccess('Test deleted successfully');
    }
}
