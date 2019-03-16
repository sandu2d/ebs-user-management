<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use App\Models\User;
use App\Models\Token;
use Illuminate\Support\Facades\Crypt;
use App\Traits\ControllerHelper;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use App\Traits\UserMap;
use Illuminate\Validation\UnauthorizedException;

class AuthController extends Controller
{
    use ControllerHelper,
        UserMap;

    public function register(RegisterRequest $request)
    {
        $user = new User([
            'name' => $request->user['name'],
            'email' => $request->user['email'],
            'password' => Crypt::encrypt($request->user['password']),
        ]);

        $user->save();

        return $this->json([
            'token' => $this->generateToken($user),
        ]);
    }

    public function login(LoginRequest $request)
    {
        if ($user = User::where([
            'email' => $request->user['email'],
        ])->first()) {
            if (Crypt::decrypt($user->password) === $request->user['password']) {

                if ($user->isBlocked()) {
                    throw new UnauthorizedException();
                }

                return $this->json([
                    'token' => $this->generateToken($user),
                ]);
            }
        }

        return 0;
    }

    private function generateToken(User $user): string
    {
        if ($token = $user->token) {
            $token->refresh();
        } else {
            $token = new Token([
                'user_id' => $user->getId(),
                'token' => app('hash')->make($user->email),
                'expires_at' => time() + 86400 // 24
            ]);
    
            $token->save();
        }

        return $token->getToken();
    }

    public function getDetails(Request $request)
    {
        return $this->json(
            $this->map($request->user())
        );
    }
}