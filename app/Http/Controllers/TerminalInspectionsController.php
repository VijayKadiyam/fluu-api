<?php

namespace App\Http\Controllers;

use App\TerminalInspection;
use App\TerminalInspectionDeficiency;
use App\Value;
use App\Vessel;
use Illuminate\Http\Request;

class TerminalInspectionsController extends Controller
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
        
        $valueCountry = Value::where('is_country', '=', True)
        ->where('site_id', '=', $request->site->id)
        ->get();
        
        return response()->json([
            'ports'         =>  $ports,
            'countries'         =>  $countries,
            'valueCountry'         =>  $valueCountry,
        ], 200);
    }
    /*
     * To get all TerminalInspection
       *
     *@
     */
    public function index(Request $request, Vessel $vessel)
    {
        $terminal_inspections = $vessel->terminal_inspections();
        $terminal_inspections = $terminal_inspections->get();
        // $count = $terminal_inspections->count();

        // $terminal_inspections = TerminalInspection::get();

        return response()->json([
            'data'     =>  $terminal_inspections
        ], 200);
    }

    /*
     * To store a new terminal_inspection
     *
     *@
     */
    public function store(Request $request, Vessel $vessel)
    {
        $request->validate([
            'date'    =>  'required',
        ]);
        if ($request->id == null || $request->id == '') {
            $terminal_inspection = new TerminalInspection($request->all());
            $vessel->terminal_inspections()->save($terminal_inspection);
            // Save PSC Inspection Deficiencies
            if (isset($request->terminal_inspection_deficiencies))
                foreach ($request->terminal_inspection_deficiencies as $deficiency) {
                    $terminal_inspection_deficiency = new TerminalInspectionDeficiency($deficiency);
                    $terminal_inspection->terminal_inspection_deficiencies()->save($terminal_inspection_deficiency);
                }
            // ---------------------------------------------------\
        } else {
            // Update Psc Inspection
            $terminal_inspection = TerminalInspection::find($request->id);
            $terminal_inspection->update($request->all());
            // Check if Psc Inspection Deficiencies deleted
            if (isset($request->terminal_inspection_deficiencies))
                $terminal_inspectionDeficienciesIdResponseArray = array_pluck($request->terminal_inspection_deficiencies, 'id');
            else
                $terminal_inspectionDeficienciesIdResponseArray = [];
            $terminal_inspectionId = $terminal_inspection->id;
            $terminal_inspectionDeficienciesIdArray = array_pluck(TerminalInspectionDeficiency::where('terminal_inspection_id', '=', $terminal_inspectionId)->get(), 'id');
            $differenceTerminalInspectionDeficiencyIds = array_diff($terminal_inspectionDeficienciesIdArray, $terminal_inspectionDeficienciesIdResponseArray);
            // Delete which is there in the database but not in the response
            if ($differenceTerminalInspectionDeficiencyIds)
                foreach ($differenceTerminalInspectionDeficiencyIds as $differenceTerminalInspectionDeficiencyId) {
                    $TerminalInspectionDeficiency = TerminalInspectionDeficiency::find($differenceTerminalInspectionDeficiencyId);
                    $TerminalInspectionDeficiency->delete();
                }

            // Update Psc Inspection Deficiencies
            if (isset($request->terminal_inspection_deficiencies))
                foreach ($request->terminal_inspection_deficiencies as $deficiency) {
                    if (!isset($deficiency['id'])) {
                        $terminal_inspection_deficiency = new TerminalInspectionDeficiency($deficiency);
                        $terminal_inspection->terminal_inspection_deficiencies()->save($terminal_inspection_deficiency);
                    } else {
                        $terminal_inspection_deficiency = TerminalInspectionDeficiency::find($deficiency['id']);
                        $terminal_inspection_deficiency->update($deficiency);
                    }
                }

            // ---------------------------------------------------
        }

        $terminal_inspection->terminal_inspection_deficiencies = $terminal_inspection->terminal_inspection_deficiencies;
        // dd($terminal_inspection);
        return response()->json([
            'data'    =>  $terminal_inspection
        ], 201);
    }

    /*
     * To view a single terminal_inspection
     *
     *@
     */
    public function show(Vessel $vessel, TerminalInspection $terminal_inspection)
    {
        $terminal_inspection->terminal_inspection_deficiencies = $terminal_inspection->terminal_inspection_deficiencies;
        $terminal_inspection->port = $terminal_inspection->port;
        $terminal_inspection->country = $terminal_inspection->country;
        return response()->json([
            'data'   =>  $terminal_inspection,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a terminal_inspection
     *
     *@
     */
    public function update(Request $request, Vessel $vessel, TerminalInspection $terminal_inspection)
    {

        $terminal_inspection->update($request->all());

        return response()->json([
            'data'  =>  $terminal_inspection
        ], 200);
    }

    public function destroy($id)
    {
        $terminal_inspection = TerminalInspection::find($id);
        $terminal_inspection->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
