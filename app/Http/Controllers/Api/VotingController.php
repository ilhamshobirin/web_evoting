<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//import model
use App\Models\Voting;
use App\Models\Candidate;
use App\Models\User;

//import Resources
use App\Http\Resources\ResponseResource;

//import Facade "Validator"
use Illuminate\Support\Facades\Validator;

//import Facade "Storage"
use Illuminate\Support\Facades\Storage;

class VotingController extends Controller
{
     /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all votings
        $votings = Voting::all();

        //return collection of votings as a resource
        return new ResponseResource(true, 'List Data Votings', $votings);
    }

     /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'vote_date'     => 'required',
            'voter'     => 'required',
            'vote_to'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::find($request->voter);

        if($user->isvoted){
            return new ResponseResource(true, 'Anda sudah melakukan voting', []);
        }else{
            //create voting
            $voting = Voting::create([
                'vote_date'     => $request->vote_date,
                'voter'     => $request->voter,
                'vote_to'   => $request->vote_to,
            ]);
    
            //find user by ID
            $user->update([
                'isvoted' => true,
            ]);
    
            //find candidate by ID
            $candidate = Candidate::find($request->vote_to);
            $candidate->update([
                'vote_count' => $candidate->vote_count+1,
            ]);

            //return response
            return new ResponseResource(true, 'Voting Berhasil', $voting);
        }


    }

    public function clear()
    {
        Voting::truncate(); 

        //return response
        return new ResponseResource(true, 'Berhasil menghapus semua data voting', []);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($id) { return new ResponseResource(true, 'Endpoint ini tidak tersedia', []);}

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, $id) { return new ResponseResource(true, 'Endpoint ini tidak tersedia', []);}

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id){return new ResponseResource(true, 'Endpoint ini tidak tersedia', []);}

}
