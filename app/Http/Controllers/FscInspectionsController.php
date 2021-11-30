<?php

namespace App\Http\Controllers;

use App\FscInspection;
use App\FscInspectionDeficiency;
use App\Value;
use App\Vessel;
use Illuminate\Http\Request;

class FscInspectionsController extends Controller
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
     * To get all FscInspection
       *
     *@
     */
    public function index(Request $request, Vessel $vessel)
    {
        $fsc_inspections = $vessel->fsc_inspections();
        $fsc_inspections = $fsc_inspections->get();
        // $count = $fsc_inspections->count();

        // $fsc_inspections = FscInspection::get();

        return response()->json([
            'data'     =>  $fsc_inspections
        ], 200);
    }

    /*
     * To store a new fsc_inspection
     *
     *@
     */
    public function store(Request $request, Vessel $vessel)
    {
        $request->validate([
            'date'    =>  'required',
        ]);
        if ($request->id == null || $request->id == '') {
            $fsc_inspection = new FscInspection($request->all());
            $vessel->fsc_inspections()->save($fsc_inspection);
            // Save PSC Inspection Deficiencies
            if (isset($request->fsc_inspection_deficiencies))
                foreach ($request->fsc_inspection_deficiencies as $deficiency) {
                    $fsc_inspection_deficiency = new FscInspectionDeficiency($deficiency);
                    $fsc_inspection->fsc_inspection_deficiencies()->save($fsc_inspection_deficiency);
                }
            // ---------------------------------------------------\
        } else {
            // Update Psc Inspection
            $fsc_inspection = FscInspection::find($request->id);
            $fsc_inspection->update($request->all());
            // Check if Psc Inspection Deficiencies deleted
            if (isset($request->fsc_inspection_deficiencies))
                $fsc_inspectionDeficienciesIdResponseArray = array_pluck($request->fsc_inspection_deficiencies, 'id');
            else
                $fsc_inspectionDeficienciesIdResponseArray = [];
            $fsc_inspectionId = $fsc_inspection->id;
            $fsc_inspectionDeficienciesIdArray = array_pluck(FscInspectionDeficiency::where('fsc_inspection_id', '=', $fsc_inspectionId)->get(), 'id');
            $differenceFscInspectionDeficiencyIds = array_diff($fsc_inspectionDeficienciesIdArray, $fsc_inspectionDeficienciesIdResponseArray);
            // Delete which is there in the database but not in the response
            if ($differenceFscInspectionDeficiencyIds)
                foreach ($differenceFscInspectionDeficiencyIds as $differenceFscInspectionDeficiencyId) {
                    $FscInspectionDeficiency = FscInspectionDeficiency::find($differenceFscInspectionDeficiencyId);
                    $FscInspectionDeficiency->delete();
                }

            // Update Psc Inspection Deficiencies
            if (isset($request->fsc_inspection_deficiencies))
                foreach ($request->fsc_inspection_deficiencies as $deficiency) {
                    if (!isset($deficiency['id'])) {
                        $fsc_inspection_deficiency = new FscInspectionDeficiency($deficiency);
                        $fsc_inspection->fsc_inspection_deficiencies()->save($fsc_inspection_deficiency);
                    } else {
                        $fsc_inspection_deficiency = FscInspectionDeficiency::find($deficiency['id']);
                        $fsc_inspection_deficiency->update($deficiency);
                    }
                }

            // ---------------------------------------------------
        }

        $fsc_inspection->fsc_inspection_deficiencies = $fsc_inspection->fsc_inspection_deficiencies;
        // dd($fsc_inspection);
        return response()->json([
            'data'    =>  $fsc_inspection
        ], 201);
    }

    /*
     * To view a single fsc_inspection
     *
     *@
     */
    public function show(Vessel $vessel, FscInspection $fsc_inspection)
    {
        $fsc_inspection->fsc_inspection_deficiencies = $fsc_inspection->fsc_inspection_deficiencies;
        $fsc_inspection->port = $fsc_inspection->port;
        $fsc_inspection->country = $fsc_inspection->country;
        return response()->json([
            'data'   =>  $fsc_inspection,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a fsc_inspection
     *
     *@
     */
    public function update(Request $request, Vessel $vessel, FscInspection $fsc_inspection)
    {

        $fsc_inspection->update($request->all());

        return response()->json([
            'data'  =>  $fsc_inspection
        ], 200);
    }

    public function destroy($id)
    {
        $fsc_inspection = FscInspection::find($id);
        $fsc_inspection->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
