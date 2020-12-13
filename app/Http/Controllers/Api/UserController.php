<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @param UserRegisterRequest $request
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request)
    {
        $user = app(UserService::class)->create($request->all());
        $success['token'] = $user->createToken($user->password)->accessToken;
        $success['name'] = $user->name;

        return response()->json(['success' => $success]);
    }
}
