<?php

namespace App\Http\Controllers;

use App\InternalAudit;
use App\InternalAuditDeficiency;
use App\Value;
use App\Vessel;
use Illuminate\Http\Request;

class InternalAuditsController extends Controller
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
     * To get all InternalAudit
       *
     *@
     */
    public function index(Request $request, Vessel $vessel)
    {
        $internal_audits = $vessel->internal_audits();
        $internal_audits = $internal_audits->get();

        return response()->json([
            'data'     =>  $internal_audits
        ], 200);
    }

    /*
     * To store a new internal_audit
     *
     *@
     */
    public function store(Request $request, Vessel $vessel)
    {
        $request->validate([
            'start_date'    =>  'required',
        ]);
        if ($request->id == null || $request->id == '') {
            $internal_audit = new InternalAudit($request->all());
            $vessel->internal_audits()->save($internal_audit);
            // Save PSC Inspection Deficiencies
            if (isset($request->internal_audit_deficiencies))
                foreach ($request->internal_audit_deficiencies as $deficiency) {
                    $internal_audit_deficiency = new InternalAuditDeficiency($deficiency);
                    $internal_audit->internal_audit_deficiencies()->save($internal_audit_deficiency);
                }
            // ---------------------------------------------------\
        } else {
            // Update Psc Inspection
            $internal_audit = InternalAudit::find($request->id);
            $internal_audit->update($request->all());
            // Check if Psc Inspection Deficiencies deleted
            if (isset($request->internal_audit_deficiencies))
                $internal_auditDeficienciesIdResponseArray = array_pluck($request->internal_audit_deficiencies, 'id');
            else
                $internal_auditDeficienciesIdResponseArray = [];
            $internal_auditId = $internal_audit->id;
            $internal_auditDeficienciesIdArray = array_pluck(InternalAuditDeficiency::where('internal_audit_id', '=', $internal_auditId)->get(), 'id');
            $differenceInternalAuditDeficiencyIds = array_diff($internal_auditDeficienciesIdArray, $internal_auditDeficienciesIdResponseArray);
            // Delete which is there in the database but not in the response
            if ($differenceInternalAuditDeficiencyIds)
                foreach ($differenceInternalAuditDeficiencyIds as $differenceInternalAuditDeficiencyId) {
                    $InternalAuditDeficiency = InternalAuditDeficiency::find($differenceInternalAuditDeficiencyId);
                    $InternalAuditDeficiency->delete();
                }

            // Update Psc Inspection Deficiencies
            if (isset($request->internal_audit_deficiencies))
                foreach ($request->internal_audit_deficiencies as $deficiency) {
                    if (!isset($deficiency['id'])) {
                        $internal_audit_deficiency = new InternalAuditDeficiency($deficiency);
                        $internal_audit->internal_audit_deficiencies()->save($internal_audit_deficiency);
                    } else {
                        $internal_audit_deficiency = InternalAuditDeficiency::find($deficiency['id']);
                        $internal_audit_deficiency->update($deficiency);
                    }
                }

            // ---------------------------------------------------
        }

        $internal_audit->internal_audit_deficiencies = $internal_audit->internal_audit_deficiencies;
        // dd($internal_audit);
        return response()->json([
            'data'    =>  $internal_audit
        ], 201);
    }

    /*
     * To view a single internal_audit
     *
     *@
     */
    public function show(Vessel $vessel, InternalAudit $internal_audit)
    {
        $internal_audit->internal_audit_deficiencies = $internal_audit->internal_audit_deficiencies;
        $internal_audit->port = $internal_audit->port;
        $internal_audit->country = $internal_audit->country;
        return response()->json([
            'data'   =>  $internal_audit,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a internal_audit
     *
     *@
     */
    public function update(Request $request, Vessel $vessel, InternalAudit $internal_audit)
    {

        $internal_audit->update($request->all());

        return response()->json([
            'data'  =>  $internal_audit
        ], 200);
    }

    public function destroy($id)
    {
        $internal_audit = InternalAudit::find($id);
        $internal_audit->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
