<?php

namespace App\Http\Controllers;

use App\SireInspection;
use App\SireInspectionDetail;
use App\Value;
use App\Vessel;
use Illuminate\Http\Request;

class SireInspectionsController extends Controller
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


        $oilMajorValue = Value::where('name', '=', 'Oil Major')
            ->where('site_id', '=', $request->site->id)
            ->first();
        $oilMajors = [];
        if ($oilMajorValue)
            $oilMajors = $oilMajorValue->active_value_lists;
        // return $oilMajors;

        $usersController = new UsersController();
        $usersResponse = $usersController->index($request);

        $viqChaptersController = new ViqChaptersController();
        $viqChaptersResponse = $viqChaptersController->index($request);


        return response()->json([
            'ports'         =>  $ports,
            'countries'         =>  $countries,
            'oilMajors'         =>  $oilMajors,
            'users'           =>  $usersResponse->getData()->data,
            'viqChapters'           =>  $viqChaptersResponse->getData()->data,
        ], 200);
    }
    /*
     * To get all SireInspection
       *
     *@
     */
    public function index(Request $request, Vessel $vessel)
    {
        $sire_inspections = $vessel->sire_inspections();
        $sire_inspections = $sire_inspections->get();
        // $count = $sire_inspections->count();

        // $sire_inspections = SireInspection::get();

        return response()->json([
            'data'     =>  $sire_inspections
        ], 200);
    }

    /*
     * To store a new sire_inspection
     *
     *@
     */
    public function store(Request $request, Vessel $vessel)
    {
        $request->validate([
            'inspection_type'    =>  'required',
        ]);
        if ($request->id == null || $request->id == '') {
            $sire_inspection = new SireInspection($request->all());
            $vessel->sire_inspections()->save($sire_inspection);
            // Save PSC Inspection Deficiencies
            if (isset($request->sire_inspection_details))
                foreach ($request->sire_inspection_details as $detail) {
                    $sire_inspection_detail = new SireInspectionDetail($detail);
                    $sire_inspection->sire_inspection_details()->save($sire_inspection_detail);
                }
            // ---------------------------------------------------\
        } else {
            // Update Psc Inspection
            $sire_inspection = SireInspection::find($request->id);
            $sire_inspection->update($request->all());
            // Check if Psc Inspection Deficiencies deleted
            if (isset($request->sire_inspection_details))
                $sire_inspectionDetailsIdResponseArray = array_pluck($request->sire_inspection_details, 'id');
            else
                $sire_inspectionDetailsIdResponseArray = [];
            $sire_inspectionId = $sire_inspection->id;
            $sire_inspectionDetailsIdArray = array_pluck(SireInspectionDetail::where('sire_inspection_id', '=', $sire_inspectionId)->get(), 'id');
            $differenceSireInspectionDetailIds = array_diff($sire_inspectionDetailsIdArray, $sire_inspectionDetailsIdResponseArray);
            // Delete which is there in the database but not in the response
            if ($differenceSireInspectionDetailIds)
                foreach ($differenceSireInspectionDetailIds as $differenceSireInspectionDetailId) {
                    $SireInspectionDetail = SireInspectionDetail::find($differenceSireInspectionDetailId);
                    $SireInspectionDetail->delete();
                }

            // Update Psc Inspection Deficiencies
            if (isset($request->sire_inspection_details))
                foreach ($request->sire_inspection_details as $detail) {
                    if (!isset($detail['id'])) {
                        $sire_inspection_detail = new SireInspectionDetail($detail);
                        $sire_inspection->sire_inspection_details()->save($sire_inspection_detail);
                    } else {
                        $sire_inspection_detail = SireInspectionDetail::find($detail['id']);
                        $sire_inspection_detail->update($detail);
                    }
                }

            // ---------------------------------------------------
        }

        $sire_inspection->sire_inspection_details = $sire_inspection->sire_inspection_details;
        // dd($sire_inspection);
        return response()->json([
            'data'    =>  $sire_inspection
        ], 201);
    }

    /*
     * To view a single sire_inspection
     *
     *@
     */
    public function show(Vessel $vessel, SireInspection $sire_inspection)
    {
        $sire_inspection->sire_inspection_details = $sire_inspection->sire_inspection_details;
        $sire_inspection->port = $sire_inspection->port;
        $sire_inspection->country = $sire_inspection->country;
        $sire_inspection->oil_major = $sire_inspection->oil_major;
        $sire_inspection->inspector = $sire_inspection->inspector;
        
        return response()->json([
            'data'   =>  $sire_inspection,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a sire_inspection
     *
     *@
     */
    public function update(Request $request, SireInspection $sire_inspection)
    {

        $sire_inspection->update($request->all());

        return response()->json([
            'data'  =>  $sire_inspection
        ], 200);
    }

    public function destroy($id)
    {
        $sire_inspection = SireInspection::find($id);
        $sire_inspection->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
