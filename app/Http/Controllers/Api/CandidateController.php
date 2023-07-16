<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//import model
use App\Models\Candidate;

//import Resources
use App\Http\Resources\CandidateResource;

//import Facade "Validator"
use Illuminate\Support\Facades\Validator;

//import Facade "Storage"
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        // $candidates = Candidate::all();
        $candidates = Candidate::latest()->paginate(5);

        //return collection of candidates as a resource
        return new CandidateResource(true, 'List Data Kandidat', $candidates);
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
            'name'     => 'required',
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'detail'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public', $image->hashName());

        //create post
        $candidate = Candidate::create([
            'name'     => $request->name,
            'image'     => $image->hashName(),
            'detail'   => $request->detail,
        ]);

        //return response
        return new CandidateResource(true, 'Data Kandidat Berhasil Ditambahkan!', $candidate);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($id)
    {
        //find post by ID
        $candidate = Candidate::find($id);

        //return single post as a resource
        return new CandidateResource(true, 'Detail Data Kandidat!', $candidate);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'detail'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $candidate = Candidate::find($id);

        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public', $image->hashName());

            //delete old image
            Storage::delete('public'.basename($candidate->image));

            //update post with new image
            $candidate->update([
                'name'     => $request->name,
                'image'     => $image->hashName(),
                'detail'   => $request->detail,
            ]);

        } else {

            //update post without image
            $candidate->update([
                'name'     => $request->name,
                'detail'   => $request->detail,
            ]);
        }

        //return response
        return new CandidateResource(true, 'Data Kandidat Berhasil Diubah!', $candidate);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id)
    {

        //find post by ID
        $candidate = Candidate::find($id);

        //delete image
        Storage::delete('public'.basename($candidate->image));

        //delete post
        $candidate->delete();

        //return response
        return new CandidateResource(true, 'Data Kandidat Berhasil Dihapus!', null);
    }
}