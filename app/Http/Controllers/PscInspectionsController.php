<?php

namespace App\Http\Controllers;

use App\PscInspection;
use App\Value;
use App\Vessel;
use Illuminate\Http\Request;

class PscInspectionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }
    public function masters(Request $request)
    {
        $portValue = Value::where('name', '=', 'VESSEL TYPE')
            ->where('site_id', '=', $request->site->id)
            ->first();
        $ports = [];
        if ($portValue)
            $ports = $portValue->active_value_lists;


        $countryValue = Value::where('name', '=', 'COUNTRY')
            ->where('site_id', '=', $request->site->id)
            ->first();
        $countries = [];
        if ($countryValue)
            $countries = $countryValue->active_value_lists;

        return response()->json([
            'ports'         =>  $ports,
            'countries'         =>  $countries,
        ], 200);
    }
    /*
     * To get all PscInspection
       *
     *@
     */
    public function index(Request $request, Vessel $vessel)
    {
        $psc_inspections = $vessel->psc_inspections();
        $psc_inspections = $psc_inspections->get();
        // $count = $psc_inspections->count();

        // $psc_inspections = PscInspection::get();

        return response()->json([
            'data'     =>  $psc_inspections
        ], 200);
    }

    /*
     * To store a new psc_inspection
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'date'    =>  'required',
        ]);
        $psc_inspection = new PscInspection($request->all());
        $request->site->psc_inspections()->save($psc_inspection);

        return response()->json([
            'data'    =>  $psc_inspection
        ], 201);
    }

    /*
     * To view a single psc_inspection
     *
     *@
     */
    public function show(PscInspection $psc_inspection)
    {
        return response()->json([
            'data'   =>  $psc_inspection,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a psc_inspection
     *
     *@
     */
    public function update(Request $request, PscInspection $psc_inspection)
    {

        $psc_inspection->update($request->all());

        return response()->json([
            'data'  =>  $psc_inspection
        ], 200);
    }

    public function destroy($id)
    {
        $psc_inspection = PscInspection::find($id);
        $psc_inspection->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
