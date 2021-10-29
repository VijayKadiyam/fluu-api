<?php

namespace App\Http\Controllers;

use App\Value;
use App\Vessel;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\Stub\ReturnSelf;

class VesselsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }

    public function masters(Request $request)
    {
        $vessel_typeValue = Value::where('name', '=', 'VESSEL TYPE')
            ->where('site_id', '=', $request->site->id)
            ->first();
        $vessel_types = [];
        if ($vessel_typeValue)
            $vessel_types = $vessel_typeValue->active_value_lists;

        $place_of_builtValue = Value::where('name', '=', 'PLACE OF BUILT')
            ->where('site_id', '=', $request->site->id)
            ->first();
        $place_of_builts = [];
        if ($place_of_builtValue)
            $place_of_builts = $place_of_builtValue->active_value_lists;

        $countryValue = Value::where('name', '=', 'COUNTRY')
            ->where('site_id', '=', $request->site->id)
            ->first();
        $countries = [];
        if ($countryValue)
            $countries = $countryValue->active_value_lists;

        return response()->json([
            'vessel_types'         =>  $vessel_types,
            'place_of_builts'         =>  $place_of_builts,
            'countries'         =>  $countries,
        ], 200);
    }
    /*
     * To get all Vessel
       *
     *@
     */
    public function index()
    {
        // $vessels = Vessel::get();
        $vessels = request()->site->vessels;
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
        $vessel->vessel_type = $vessel->vessel_type;
        $vessel->place_of_built = $vessel->place_of_built;
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
