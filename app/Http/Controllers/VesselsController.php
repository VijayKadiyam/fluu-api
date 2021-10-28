<?php

namespace App\Http\Controllers;

use App\Vessel;
use Illuminate\Http\Request;

class VesselsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }

    /*
     * To get all Vessel
       *
     *@
     */
    public function index()
    {
        $vessels = Vessel::get();

        return response()->json([
            'data'     =>  $vessels
        ], 200);
    }

    /*
     * To store a new vessel
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'serial_no'    =>  'required',
        ]);
        $vessel = new Vessel($request->all());
        $request->site->vessels()->save($vessel);

        return response()->json([
            'data'    =>  $vessel
        ], 201);
    }

    /*
     * To view a single vessel
     *
     *@
     */
    public function show(Vessel $vessel)
    {
        return response()->json([
            'data'   =>  $vessel,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a vessel
     *
     *@
     */
    public function update(Request $request, Vessel $vessel)
    {

        $vessel->update($request->all());

        return response()->json([
            'data'  =>  $vessel
        ], 200);
    }

    public function destroy($id)
    {
        $vessel = Vessel::find($id);
        $vessel->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
