<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//import model
use App\Models\Voting;

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

        //create post
        $voting = Voting::create([
            'vote_date'     => $request->vote_date,
            'voter'     => $request->voter,
            'vote_to'   => $request->vote_to,
        ]);

        //return response
        return new ResponseResource(true, 'Voting Berhasil', $voting);
    }

    public function clear()
    {
        Voting::truncate(); 

        //return response
        return new ResponseResource(true, 'Berhasil menghapus semua data voting', null);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($id) { return new ResponseResource(true, 'Endpoint ini tidak tersedia', null);}

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, $id) { return new ResponseResource(true, 'Endpoint ini tidak tersedia', null);}

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id){return new ResponseResource(true, 'Endpoint ini tidak tersedia', null);}

}
