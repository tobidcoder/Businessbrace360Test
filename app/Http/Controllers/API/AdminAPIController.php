<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAdminAPIRequest;
use App\Http\Requests\API\UpdateAdminAPIRequest;
use App\Models\Admin;
use App\Repositories\AdminRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AdminController
 * @package App\Http\Controllers\API
 */

class AdminAPIController extends AppBaseController
{
    /** @var  AdminRepository */
    private $adminRepository;

    public function __construct(AdminRepository $adminRepo)
    {
        $this->adminRepository = $adminRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @OA\Get(
     *      path="/admins",
     *      summary="Get a listing of the Admins.",
     *      tags={"Admin"},
     *      description="Get all Admins",
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
     *                  @OA\Items(ref="#/components/schemas/Admin")
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
        $admins = $this->adminRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($admins->toArray(), 'Admins retrieved successfully');
    }

    /**
     * @param CreateAdminAPIRequest $request
     * @return Response
     *
     * @OA\Post(
     *      path="/admins",
     *      summary="Store a newly created Admin in storage",
     *      tags={"Admin"},
     *      description="Store Admin",
     *      @OA\RequestBody(
     *          description="Admin that should be stored",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/Admin")
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
     *                  ref="#/components/schemas/Admin"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAdminAPIRequest $request)
    {
        $input = $request->all();

        try{
            $validate = Validator::make($input,[
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ]);

            if($validate->fails()){
                return $this->sendError('Validations Error', $validate->errors());
            }

            $admin = Admin::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),

            ]);
            if($admin) {
                $token = $admin->createToken('businessbrace360')->accessToken;

                $admin['token'] = $token;


                return $this->sendResponse($admin, 'Admin Register successful!', 'BT001');
            } else {
                return $this->sendError('Error', 'something went wrong!');
            }

        }catch(\Exception $e){
            Log::error('Error in Register Admin : '.$e);
        }
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Get(
     *      path="/admins/{id}",
     *      summary="Display the specified Admin",
     *      tags={"Admin"},
     *      description="Get Admin",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Admin",
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
     *                  ref="#/components/schemas/Admin"
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
        /** @var Admin $admin */
        $admin = $this->adminRepository->find($id);

        if (empty($admin)) {
            return $this->sendError('Admin not found');
        }

        return $this->sendResponse($admin->toArray(), 'Admin retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAdminAPIRequest $request
     * @return Response
     *
     * @OA\Put(
     *      path="/admins/{id}",
     *      summary="Update the specified Admin in storage",
     *      tags={"Admin"},
     *      description="Update Admin",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Admin",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          description="Admin that should be updated",
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/Admin")
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
     *                  ref="#/components/schemas/Admin"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAdminAPIRequest $request)
    {
        $input = $request->all();

        /** @var Admin $admin */
        $admin = $this->adminRepository->find($id);

        if (empty($admin)) {
            return $this->sendError('Admin not found');
        }

        $admin = $this->adminRepository->update($input, $id);

        return $this->sendResponse($admin->toArray(), 'Admin updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @OA\Delete(
     *      path="/admins/{id}",
     *      summary="Remove the specified Admin from storage",
     *      tags={"Admin"},
     *      description="Delete Admin",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Admin",
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
        /** @var Admin $admin */
        $admin = $this->adminRepository->find($id);

        if (empty($admin)) {
            return $this->sendError('Admin not found');
        }

        $admin->delete();

        return $this->sendSuccess('Admin deleted successfully');
    }

    public function login(Request $request)
    {
        $input = $request->all();
        try{
            $validate = Validator::make($input,[
                'email' => 'required',
                'password' => 'required',
            ]);

            if($validate->fails()){
                return $this->sendError('Validations Error', $validate->errors());
            }

            $login = Admin::where('email', $request->email)->first();
            if ($login) {
                $passowrd_check = Hash::check($request->password, $login->password);

                if(!$passowrd_check){

                    return $this->sendError('Incorrect password', ['error' => 'Incorrect Password']);

                }
                $token = $login->createToken('businessbrace360')->accessToken;

                $login['token'] = $token;

                return $this->sendResponse($login, 'Admin Login successful!', 'BT006');

            } else {
                return $this->sendError('Error', 'Email or password not correct!');
            }

        }catch(\Exception $e){
            Log::error('Error in Admin login : '.$e);
        }
    }

}
