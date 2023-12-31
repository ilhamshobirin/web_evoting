<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Resources\ResponseResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'user_name' => 'required',
            'password' => 'required',
            'ktp' => 'required',
            'age' => 'required',
            'address' => 'nullable',
            'user_level' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ada kesalahan',
                'data' => $validator->errors()
            ]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['name'] = $user->name;
        $success['user_name'] = $user->user_name;
        $success['ktp'] = $user->ktp;
        $success['age'] = $user->age;
        $success['address'] = $user->address ?? '';
        $success['user_level'] = $user->user_level ?? 0;

        return new ResponseResource(true, 'Registrasi Berhasil', $success);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['user_name' => $request->user_name, 'password' => $request->password])) {
            $auth = Auth::user();
            $success['id'] = $auth->id;
            $success['token'] = $auth->createToken('auth_token')->plainTextToken;
            $success['name'] = $auth->name;
            $success['user_name'] = $auth->user_name;
            $success['ktp'] = $auth->ktp;
            $success['age'] = $auth->age;
            $success['address'] = $auth->address;
            $success['user_level'] = $auth->user_level;
            $success['isvoted'] = $auth->isvoted;

            return new ResponseResource(true, 'Login Berhasil', $success);
        } else {
            return new ResponseResource(true, 'Cek user name dan password lagi', null);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
    
        return response()->json(
            [
                'message' => 'Successfully logged out'
            ]
        );
    }

}
