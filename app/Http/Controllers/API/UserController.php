<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\traits\ApiResponseTrait;
use App\Services\User\UserService;
class UserController extends Controller
{
    //
    use ApiResponseTrait;
    protected $userService;
    // public function __construct(UserService $userService)
    // {
    //     $this->userService = $userService;
    // }

    /**
     * Get all users
     */
    public function index()
    {
        try {
            $users = User::all();
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
            $user = User::find($id);
            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }
            return $this->successResponse($user, 'User retrieved successfully', 200);
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
            ]);

            $validated['password'] = bcrypt($validated['password']);
            $user = User::create($validated);
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
            $user = User::find($id);
            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:users,email,' . $id,
                'password' => 'sometimes|required|string|min:8|confirmed',
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
            $user = User::find($id);
            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }
            $user->delete();
            return $this->successResponse(null, 'User deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
