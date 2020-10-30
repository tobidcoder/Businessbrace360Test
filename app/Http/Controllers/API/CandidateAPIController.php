<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCandidateAPIRequest;
use App\Http\Requests\API\UpdateCandidateAPIRequest;
use App\Models\Candidate;
use App\Repositories\CandidateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Log;
use Response;
use Validator;
use Illuminate\Support\Facades\Hash;


/**
 * Class CandidateController
 * @package App\Http\Controllers\API
 */

class CandidateAPIController extends AppBaseController
{
    /** @var  CandidateRepository */
    private $candidateRepository;

    public function __construct(CandidateRepository $candidateRepo)
    {
        $this->candidateRepository = $candidateRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @OA\Get(
     *      path="/candidates",
     *      summary="Get a listing of the Candidates.",
     *      tags={"Candidate"},
     *      description="Get all Candidates",
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
     *                  @OA\Items(ref="#/components/schemas/Candidate")
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
        $candidates = $this->candidateRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($candidates->toArray(), 'Candidates retrieved successfully');
    }

    /**
     * @param CreateCandidateAPIRequest $request
     * @return Response
     *
     * @OA\Post(
     *      path="/candidates",
     *      summary="Store a newly created Candidate in storage",
     *      tags={"Candidate"},
     *      description="Store Candidate",
     *      @OA\RequestBody(
     *          description="Candidate that should be stored",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/Candidate")
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
     *                  ref="#/components/schemas/Candidate"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCandidateAPIRequest $request)
    {
        $input = $request->all();
//
//
        try{
            $validate = Validator::make($input,[
                'first_name' => 'required',
                'last_name' => 'required',
                'phone_number' => 'required',
                'username' => 'required',
                'email' => 'required|email|unique:users',
                'address' => 'required',
                'password' => 'required',
            ]);

            if($validate->fails()){
                return $this->sendError('Validations Error', $validate->errors());
            }

            $user = Candidate::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'address' => $request->address,
                'phone_number' => $request->phone_number,
            ]);
            if($user) {
                $token = $user->createToken('businessbrace360')->accessToken;

                $user['token'] = $token;


                return $this->sendResponse($user, 'Candidate Register successful!', 'BT001');
            } else {
                return $this->sendError('Error', 'something went wrong!');
            }

        }catch(\Exception $e){
           Log::error('Error in Register Candidate : '.$e);
        }
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Get(
     *      path="/candidates/{id}",
     *      summary="Display the specified Candidate",
     *      tags={"Candidate"},
     *      description="Get Candidate",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Candidate",
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
     *                  ref="#/components/schemas/Candidate"
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
        /** @var Candidate $candidate */
        $candidate = $this->candidateRepository->find($id);

        if (empty($candidate)) {
            return $this->sendError('Candidate not found');
        }

        return $this->sendResponse($candidate->toArray(), 'Candidate retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCandidateAPIRequest $request
     * @return Response
     *
     * @OA\Put(
     *      path="/candidates/{id}",
     *      summary="Update the specified Candidate in storage",
     *      tags={"Candidate"},
     *      description="Update Candidate",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Candidate",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          description="Candidate that should be updated",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/Candidate")
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
     *                  ref="#/components/schemas/Candidate"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCandidateAPIRequest $request)
    {
        $input = $request->all();

        /** @var Candidate $candidate */
        $candidate = $this->candidateRepository->find($id);

        if (empty($candidate)) {
            return $this->sendError('Candidate not found');
        }

        $candidate = $this->candidateRepository->update($input, $id);

        return $this->sendResponse($candidate->toArray(), 'Candidate updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Delete(
     *      path="/candidates/{id}",
     *      summary="Remove the specified Candidate from storage",
     *      tags={"Candidate"},
     *      description="Delete Candidate",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Candidate",
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
        /** @var Candidate $candidate */
        $candidate = $this->candidateRepository->find($id);

        if (empty($candidate)) {
            return $this->sendError('Candidate not found');
        }

        $candidate->delete();

        return $this->sendSuccess('Candidate deleted successfully');
    }

    /**
     * @param CreateCandidateAPIRequest $request
     * @return Response
     *
     * @OA\Post(
     *      path="/candidates/login",
     *      summary="Candidate login",
     *      tags={"Candidate"},
     *      description="Login candidate",
     *      @OA\RequestBody(
     *          description="Candidate that can login",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/Candidate")
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
     *                  ref="#/components/schemas/Candidate"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */

    public function login(Request $request)
    {
//

        $input = $request->all();
        try{
            $validate = Validator::make($input,[
                'email' => 'required',
                'password' => 'required',
            ]);

            if($validate->fails()){
                return $this->sendError('Validations Error', $validate->errors());
            }

            $login = Candidate::where('email', $request->email)->first();
            if ($login) {
                $passowrd_check = Hash::check($request->password, $login->password);

                if(!$passowrd_check){

                    return $this->sendError('Incorrect password', ['error' => 'Incorrect Password']);

                }
                $token = $login->createToken('businessbrace360')->accessToken;

                $user['token'] = $token;

                return $this->sendResponse($user, 'Candidate Login successful!', 'BT006');

            } else {
                return $this->sendError('Error', 'Email or password not correct!');
            }
        }catch(\Exception $e){
            Log::error('Error in Candidate login : '.$e);
        }
    }

}
