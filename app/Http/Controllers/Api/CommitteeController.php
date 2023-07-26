<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Http\Resources\ResponseResource;


class CommitteeController extends Controller
{
    public function all_panitia(){
        $all_committee = DB::table('users')->whereRaw('user_level = 2')->get(); 

        return new ResponseResource(true, 'Berhasil Mendapatkan semua data panitia', $all_committee);
    }

    public function add_panitia(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'user_name' => 'required',
            'password' => 'required',
            'ktp' => 'required',
            'age' => 'required',
            'address' => 'nullable',
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
        $input['user_level'] = 2;
        $user = User::create($input);

        $success['name'] = $user->name;
        $success['user_name'] = $user->user_name;
        $success['ktp'] = $user->ktp;
        $success['age'] = $user->age;
        $success['address'] = $user->address ?? '';
        $success['user_level'] = $user->user_level ?? 0;

        return new ResponseResource(true, 'Berhasil menambahkan data panitia', $success);
    }
}
