<?php

namespace App\Http\Controllers;

use App\ChartererInspection;
use App\ChartererInspectionDeficiency;
use App\Value;
use App\Vessel;
use Illuminate\Http\Request;

class ChartererInspectionsController extends Controller
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
     * To get all ChartererInspection
       *
     *@
     */
    public function index(Request $request, Vessel $vessel)
    {
        $charterer_inspections = $vessel->charterer_inspections();
        $charterer_inspections = $charterer_inspections->get();
        // $count = $charterer_inspections->count();

        // $charterer_inspections = ChartererInspection::get();

        return response()->json([
            'data'     =>  $charterer_inspections
        ], 200);
    }

    /*
     * To store a new charterer_inspection
     *
     *@
     */
    public function store(Request $request, Vessel $vessel)
    {
        $request->validate([
            'date'    =>  'required',
        ]);
        if ($request->id == null || $request->id == '') {
            $charterer_inspection = new ChartererInspection($request->all());
            $vessel->charterer_inspections()->save($charterer_inspection);
            // Save PSC Inspection Deficiencies
            if (isset($request->charterer_inspection_deficiencies))
                foreach ($request->charterer_inspection_deficiencies as $deficiency) {
                    $charterer_inspection_deficiency = new ChartererInspectionDeficiency($deficiency);
                    $charterer_inspection->charterer_inspection_deficiencies()->save($charterer_inspection_deficiency);
                }
            // ---------------------------------------------------\
        } else {
            // Update Psc Inspection
            $charterer_inspection = ChartererInspection::find($request->id);
            $charterer_inspection->update($request->all());
            // Check if Psc Inspection Deficiencies deleted
            if (isset($request->charterer_inspection_deficiencies))
                $charterer_inspectionDeficienciesIdResponseArray = array_pluck($request->charterer_inspection_deficiencies, 'id');
            else
                $charterer_inspectionDeficienciesIdResponseArray = [];
            $charterer_inspectionId = $charterer_inspection->id;
            $charterer_inspectionDeficienciesIdArray = array_pluck(ChartererInspectionDeficiency::where('charterer_inspection_id', '=', $charterer_inspectionId)->get(), 'id');
            $differenceChartererInspectionDeficiencyIds = array_diff($charterer_inspectionDeficienciesIdArray, $charterer_inspectionDeficienciesIdResponseArray);
            // Delete which is there in the database but not in the response
            if ($differenceChartererInspectionDeficiencyIds)
                foreach ($differenceChartererInspectionDeficiencyIds as $differenceChartererInspectionDeficiencyId) {
                    $ChartererInspectionDeficiency = ChartererInspectionDeficiency::find($differenceChartererInspectionDeficiencyId);
                    $ChartererInspectionDeficiency->delete();
                }

            // Update Psc Inspection Deficiencies
            if (isset($request->charterer_inspection_deficiencies))
                foreach ($request->charterer_inspection_deficiencies as $deficiency) {
                    if (!isset($deficiency['id'])) {
                        $charterer_inspection_deficiency = new ChartererInspectionDeficiency($deficiency);
                        $charterer_inspection->charterer_inspection_deficiencies()->save($charterer_inspection_deficiency);
                    } else {
                        $charterer_inspection_deficiency = ChartererInspectionDeficiency::find($deficiency['id']);
                        $charterer_inspection_deficiency->update($deficiency);
                    }
                }

            // ---------------------------------------------------
        }

        $charterer_inspection->charterer_inspection_deficiencies = $charterer_inspection->charterer_inspection_deficiencies;
        // dd($charterer_inspection);
        return response()->json([
            'data'    =>  $charterer_inspection
        ], 201);
    }

    /*
     * To view a single charterer_inspection
     *
     *@
     */
    public function show(Vessel $vessel, ChartererInspection $charterer_inspection)
    {
        $charterer_inspection->charterer_inspection_deficiencies = $charterer_inspection->charterer_inspection_deficiencies;
        $charterer_inspection->port = $charterer_inspection->port;
        $charterer_inspection->country = $charterer_inspection->country;
        return response()->json([
            'data'   =>  $charterer_inspection,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a charterer_inspection
     *
     *@
     */
    public function update(Request $request, Vessel $vessel, ChartererInspection $charterer_inspection)
    {

        $charterer_inspection->update($request->all());

        return response()->json([
            'data'  =>  $charterer_inspection
        ], 200);
    }

    public function destroy($id)
    {
        $charterer_inspection = ChartererInspection::find($id);
        $charterer_inspection->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
