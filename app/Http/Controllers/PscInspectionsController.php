<?php

namespace App\Http\Controllers;

use App\PscInspection;
use App\PscInspectionDeficiency;
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
        $portValue = Value::where('name', '=', 'PORT')
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
    public function store(Request $request, Vessel $vessel)
    {
        $request->validate([
            'date'    =>  'required',
        ]);
        if ($request->id == null || $request->id == '') {
            $psc_inspection = new PscInspection($request->all());
            $vessel->psc_inspections()->save($psc_inspection);
            // Save PSC Inspection Deficiencies
            if (isset($request->psc_inspection_deficiencies))
                foreach ($request->psc_inspection_deficiencies as $deficiency) {
                    $psc_inspection_deficiency = new PscInspectionDeficiency($deficiency);
                    $psc_inspection->psc_inspection_deficiencies()->save($psc_inspection_deficiency);
                }
            // ---------------------------------------------------\
        } else {
            // Update Psc Inspection
            $psc_inspection = PscInspection::find($request->id);
            $psc_inspection->update($request->all());
            // Check if Psc Inspection Deficiencies deleted
            if (isset($request->psc_inspection_deficiencies))
                $psc_inspectionDeficienciesIdResponseArray = array_pluck($request->psc_inspection_deficiencies, 'id');
            else
                $psc_inspectionDeficienciesIdResponseArray = [];
            $psc_inspectionId = $psc_inspection->id;
            $psc_inspectionDeficienciesIdArray = array_pluck(PscInspectionDeficiency::where('psc_inspection_id', '=', $psc_inspectionId)->get(), 'id');
            $differencePscInspectionDeficiencyIds = array_diff($psc_inspectionDeficienciesIdArray, $psc_inspectionDeficienciesIdResponseArray);
            // Delete which is there in the database but not in the response
            if ($differencePscInspectionDeficiencyIds)
                foreach ($differencePscInspectionDeficiencyIds as $differencePscInspectionDeficiencyId) {
                    $PscInspectionDeficiency = PscInspectionDeficiency::find($differencePscInspectionDeficiencyId);
                    $PscInspectionDeficiency->delete();
                }

            // Update Psc Inspection Deficiencies
            if (isset($request->psc_inspection_deficiencies))
                foreach ($request->psc_inspection_deficiencies as $deficiency) {
                    if (!isset($deficiency['id'])) {
                        $psc_inspection_deficiency = new PscInspectionDeficiency($deficiency);
                        $psc_inspection->psc_inspection_deficiencies()->save($psc_inspection_deficiency);
                    } else {
                        $psc_inspection_deficiency = PscInspectionDeficiency::find($deficiency['id']);
                        $psc_inspection_deficiency->update($deficiency);
                    }
                }

            // ---------------------------------------------------
        }

        $psc_inspection->psc_inspection_deficiencies = $psc_inspection->psc_inspection_deficiencies;
        // dd($psc_inspection);
        return response()->json([
            'data'    =>  $psc_inspection
        ], 201);
    }

    /*
     * To view a single psc_inspection
     *
     *@
     */
    public function show(Vessel $vessel, PscInspection $psc_inspection)
    {
        $psc_inspection->psc_inspection_deficiencies = $psc_inspection->psc_inspection_deficiencies;
        $psc_inspection->port = $psc_inspection->port;
        $psc_inspection->country = $psc_inspection->country;
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
    public function update(Request $request, Vessel $vessel, PscInspection $psc_inspection)
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
