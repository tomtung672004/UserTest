<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Services\User\UserService;
class UserController extends Controller
{
    //
    use ApiResponseTrait;
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        //$this->middleware('auth:api');
    }

    /**
     * Get all users
     */
    public function index()
    {
        try {
            $this->middleware('check.user.job:Admin');
            $users = $this->userService->getAll();
            return $this->successResponse($users, 'Users retrieved successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
    /**
     * Get a single user by ID
     */
    public function show($id)
    {
        try {
            $user = $this->userService->getById($id);
            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }
            return $user;
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Create a new user
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                //'job_id' => 'default|null|exists:jobs,id',
            ]);

            $validated['password'] = bcrypt($validated['password']);
            $user = $this->userService->create($validated);
            return $this->successResponse($user, 'User created successfully', 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Update an existing user
     */
    public function update(Request $request, $id)
    {
        try {
            $user = $this->userService->getById($id);
            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:users,email,' . $id,
                'password' => 'sometimes|required|string|min:8|confirmed',
                'job_id' => 'nullable|exists:jobs,id',
            ]);

            if (isset($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            }

            $user->update($validated);
            return $this->successResponse($user, 'User updated successfully', 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Delete a user
     */
    public function destroy($id)
    {
        try {
            $user = $this->userService->getById($id);
            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }
            $this->userService->delete($id);
            return $this->successResponse(null, 'User deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
