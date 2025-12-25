<?php

namespace App\Http\Controllers;

use App\Exceptions\LoginException;
use App\Exceptions\RegisterException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Service\AuthService;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ApiResponseTrait;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        try {
            $result = $this->authService->login($request);

            return $this->successResponse($result);
        } catch (LoginException $e) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        } catch (\Throwable $e) {
            Log::error('Error ketika mencoba login: '.$e->getMessage());

            return $this->errorResponse('Oops something wrong.');
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $result = $this->authService->register($request);

            return $this->successResponse($result);
        } catch (RegisterException $e) {
            return $this->errorResponse($e->getMessage());
        } catch (\Throwable $e) {
            Log::error('Error ketika mencoba register user: '.$e->getMessage());

            return $this->errorResponse('Oops something wrong.');
        }
    }
}
