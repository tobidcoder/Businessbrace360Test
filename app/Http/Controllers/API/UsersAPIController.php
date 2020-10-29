<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUsersAPIRequest;
use App\Http\Requests\API\UpdateUsersAPIRequest;
use App\Models\Users;
use App\Repositories\UsersRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UsersController
 * @package App\Http\Controllers\API
 */

class UsersAPIController extends AppBaseController
{
    /** @var  UsersRepository */
    private $usersRepository;

    public function __construct(UsersRepository $usersRepo)
    {
        $this->usersRepository = $usersRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @OA\Get(
     *      path="/users",
     *      summary="Get a listing of the Users.",
     *      tags={"Users"},
     *      description="Get all Users",
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
     *                  @OA\Items(ref="#/components/schemas/Users")
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
        $users = $this->usersRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($users->toArray(), 'Users retrieved successfully');
    }

    /**
     * @param CreateUsersAPIRequest $request
     * @return Response
     *
     * @OA\Post(
     *      path="/users",
     *      summary="Store a newly created Users in storage",
     *      tags={"Users"},
     *      description="Store Users",
     *      @OA\RequestBody(
     *          description="Users that should be stored",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/Users")
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
     *                  ref="#/components/schemas/Users"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateUsersAPIRequest $request)
    {
//        $input = $request->all();
//
//        $users = $this->usersRepository->create($input);
//
//        return $this->sendResponse($users->toArray(), 'Users saved successfully');
        try{
            $validate = Validator::make($request->data,[
                'name' => 'required',
                'phone_number' => 'required',
                'email' => 'required|email|unique:users',
                'address' => 'required',
                'password' => 'required',hpp
            ]);

            if($validate->fails()){
                return $this->sendError('Validations Error', $validate->errors());
            }

            $user = User::create([
                'name' => $request->data['name'],
                'email' => $request->data['email'],
                'password' => bcrypt($request->data['password']),
                'address' => $request->data['address'],
                'phone_number' => $request->data['phone_number'],
            ]);
            if($user) {
                $token = $user->createToken('pizza-task')->accessToken;
                $users['name'] = $user->name;
                $users['email'] = $user->email;
                $users['address'] = $user->address;
                $users['user_id'] = $user->id;
                $users['address'] = $user->address;
                $users['token'] = $token;
                $users['phone_number'] = $user->phone_number;

                Cache::forever('email'.$request->data['email'].'', $request->data['email']);

                return $this->sendResponse($users, 'User Register successful!', 'OD005');
            } else {
                return $this->sendError('Error', 'something went wrong!');
            }

        }catch(\Exception $e){
            Log::error('Error in Register user : '.$e);
        }
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Get(
     *      path="/users/{id}",
     *      summary="Display the specified Users",
     *      tags={"Users"},
     *      description="Get Users",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Users",
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
     *                  ref="#/components/schemas/Users"
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
        /** @var Users $users */
        $users = $this->usersRepository->find($id);

        if (empty($users)) {
            return $this->sendError('Users not found');
        }

        return $this->sendResponse($users->toArray(), 'Users retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateUsersAPIRequest $request
     * @return Response
     *
     * @OA\Put(
     *      path="/users/{id}",
     *      summary="Update the specified Users in storage",
     *      tags={"Users"},
     *      description="Update Users",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Users",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          description="Users that should be updated",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/Users")
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
     *                  ref="#/components/schemas/Users"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateUsersAPIRequest $request)
    {
        $input = $request->all();

        /** @var Users $users */
        $users = $this->usersRepository->find($id);

        if (empty($users)) {
            return $this->sendError('Users not found');
        }

        $users = $this->usersRepository->update($input, $id);

        return $this->sendResponse($users->toArray(), 'Users updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Delete(
     *      path="/users/{id}",
     *      summary="Remove the specified Users from storage",
     *      tags={"Users"},
     *      description="Delete Users",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Users",
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
        /** @var Users $users */
        $users = $this->usersRepository->find($id);

        if (empty($users)) {
            return $this->sendError('Users not found');
        }

        $users->delete();

        return $this->sendSuccess('Users deleted successfully');
    }
}
