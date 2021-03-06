<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JWTAuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function user() {
        return response()->json(auth('api')->user());
    }

    public function register(Request $req) {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toJson()
            ], 200);
        }

        $user = new User();
        $user->fill($req->all());
        $user->password = bcrypt($req->password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function login(Request $req) {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toJson(),
            ], 200);
        }

        // $credentials = request(['email', 'password']);
        $credentials = $req->all();

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unuthorized'], 401);
        }

        // $user = User::where('email', $req->email)->get();
        // $token = auth('api')->login($user);

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function refresh() {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function logout() {
        auth('api')->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'logout',
        ], 200);
    }
}
