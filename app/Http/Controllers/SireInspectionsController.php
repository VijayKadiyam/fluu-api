<?php

namespace App\Http\Controllers;

use App\SireInspection;
use App\SireInspectionDetail;
use Illuminate\Http\Request;

class SireInspectionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }

    /*
     * To get all SireInspection
       *
     *@
     */
    public function index()
    {
        $sire_inspections = SireInspection::get();

        return response()->json([
            'data'     =>  $sire_inspections
        ], 200);
    }

    /*
     * To store a new sire_inspection
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'inspection_type'    =>  'required',
        ]);

        if ($request->id == null || $request->id == '') {
            $sire_inspection = new SireInspection($request->all());
            $request->site->sire_inspections()->save($sire_inspection);
            // Save Sire Inspection Details
            if (isset($request->sire_inspection_details))
                foreach ($request->sire_inspection_details as $detail) {
                    $sire_inspection_detail = new SireInspectionDetail($detail);
                    $sire_inspection->sire_inspection_details()->save($sire_inspection_detail);
                }
            // ---------------------------------------------------\
        } else {
            // Update Sire Inspection
            $sire_inspection = SireInspection::find($request->id);
            $sire_inspection->update($request->all());
            // Check if Sire Inspection Details deleted
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

            // Update Sire Inspection Details
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
        return response()->json([
            'data'    =>  $sire_inspection
        ], 201);
    }

    /*
     * To view a single sire_inspection
     *
     *@
     */
    public function show(SireInspection $sire_inspection)
    {
        $sire_inspection->sire_inspection_details = $sire_inspection->sire_inspection_details;

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
        $sire_inspection->sire_inspection_details = $sire_inspection->sire_inspection_details;

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
