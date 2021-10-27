<?php

namespace App\Http\Controllers;

use App\NearMiss;
use Illuminate\Http\Request;

class NearMissesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }

    /*
     * To get all NearMiss
       *
     *@
     */
    public function index()
    {
        $nearMisses = NearMiss::get();

        return response()->json([
            'data'     =>  $nearMisses
        ], 200);
    }

    /*
     * To store a new nearMiss
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'number_reported'    =>  'required',
        ]);
        $nearMiss = new NearMiss($request->all());
        $request->site->viq_chapters()->save($nearMiss);

        return response()->json([
            'data'    =>  $nearMiss
        ], 201);
    }

    /*
     * To view a single nearMiss
     *
     *@
     */
    public function show(NearMiss $nearMiss)
    {
        return response()->json([
            'data'   =>  $nearMiss,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a nearMiss
     *
     *@
     */
    public function update(Request $request, NearMiss $nearMiss)
    {

        $nearMiss->update($request->all());

        return response()->json([
            'data'  =>  $nearMiss
        ], 200);
    }

    public function destroy($id)
    {
        $nearMiss = NearMiss::find($id);
        $nearMiss->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
