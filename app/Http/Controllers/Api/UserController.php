<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Helpers\ErrorJsonChanger;

class UserController extends Controller
{
    use ErrorJsonChanger;
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'min:2', 'max:50'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:6', 'max:30'],
            'phone' => ['required', 'min:9', 'max:20'],
            'address' => ['required', 'min:5'],
            'role_id' => ['nullable']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Unprocessable dat.',
                'errors' => $this->arrayToJsonChanger($validator->errors()->messages())
            ], 422);
        }

        $isExists = User::where('email', request('email'))->exists();

        if ($isExists) {
            return response()->json([
                'message' => 'Email already exists.',
            ], 422);
        }

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password'),
            'address' => request('address'),
            'phone' => request('phone'),
            'role_id' => request('role_id') ?? 1
        ]);

        $token = $user->createToken('user-token')->plainTextToken;

        return response()->json([
            'message' => 'User created',
            'token' => $token
        ], 201);
    }

    public function login()
    {
        $validator = Validator::make(request()->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'max:30'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Unprocessable dat.',
                'errors' => $this->arrayToJsonChanger($validator->errors()->messages())
            ], 422);
        }

        $user = User::where('email', request('email'))->first();

        if (!$user) {
            return response()->json([
                'errors' => [
                    'email' => 'Email does\'t exists.'
                ],
            ], 422);
        }

        $isPasswordCorrect = Hash::check(request('password'), $user->password);

        if (!$isPasswordCorrect) {
            return response()->json([
                'message' => 'Password doesn\'t correct'
            ]);
        }

        $token = $user->createToken('user-token')->plainTextToken;

        return response()->json([
            'message' => 'login success',
            'token' => $token
        ]);
    }

    public function profileImageUpdate(User $user)
    {

        $validator = Validator::make(request()->all(), [
            'profile' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Unprocessable data.',
                'errors' => $this->arrayToJsonChanger($validator->errors()->messages())
            ], 422);
        }

        if ($user->id != request()->user()->id) {
            return response()->json([
                'errors' => [
                    'message' => 'U cant update another user\'s profile. '
                ]
            ], 422);
        }

        $path = request('profile')->store('public');

        $url = Storage::url($path);

        $user->update([
            'profile' => $url
        ]);

        return response()->json([
            'message' => 'Profile Update Successful.'
        ], 200);
    }
}
