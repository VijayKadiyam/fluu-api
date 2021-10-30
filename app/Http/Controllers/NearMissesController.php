<?php

namespace App\Http\Controllers;

use App\NearMiss;
use App\Value;
use Illuminate\Http\Request;

class NearMissesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }

    public function masters(Request $request)
    {
        $locationValue = Value::where('name', '=', 'LOCATION')
            ->where('site_id', '=', $request->site->id)
            ->first();
        $locations = [];
        if ($locationValue)
            $locations = $locationValue->active_value_lists;

        $categoryValue = Value::where('name', '=', 'CATEGORY')
            ->where('site_id', '=', $request->site->id)
            ->first();
        $categories = [];
        if ($categoryValue)
            $categories = $categoryValue->active_value_lists;

        $activityValue = Value::where('name', '=', 'ACTIVITY')
            ->where('site_id', '=', $request->site->id)
            ->first();
        $activities = [];
        if ($activityValue)
            $activities = $activityValue->active_value_lists;

        $basic_causeValue = Value::where('name', '=', 'BASIC CAUSE')
            ->where('site_id', '=', $request->site->id)
            ->first();
        $basic_causes = [];
        if ($basic_causeValue)
            $basic_causes = $basic_causeValue->active_value_lists;

        return response()->json([
            'locations'         =>  $locations,
            'categories'         =>  $categories,
            'activities'         =>  $activities,
            'basic_causes'         =>  $basic_causes,
        ], 200);
    }
    /*
     * To get all NearMiss
       *
     *@
     */
    public function index()
    {
        $nearMisses = request()->site->near_misses;

        return response()->json([
            'data'     =>  $nearMisses
        ], 200);
    }

    /*
     * To store a new nearMiss
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'number_reported'    =>  'required',
        ]);
        $nearMiss = new NearMiss($request->all());
        $request->site->viq_chapters()->save($nearMiss);

        return response()->json([
            'data'    =>  $nearMiss
        ], 201);
    }

    /*
     * To view a single nearMiss
     *
     *@
     */
    public function show(NearMiss $nearMiss)
    {
        $nearMiss->location = $nearMiss->location;
        $nearMiss->category = $nearMiss->category;
        $nearMiss->activity = $nearMiss->activity;
        $nearMiss->basic_cause = $nearMiss->basic_cause;
        return response()->json([
            'data'   =>  $nearMiss,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a nearMiss
     *
     *@
     */
    public function update(Request $request, NearMiss $nearMiss)
    {

        $nearMiss->update($request->all());

        return response()->json([
            'data'  =>  $nearMiss
        ], 200);
    }

    public function destroy($id)
    {
        $nearMiss = NearMiss::find($id);
        $nearMiss->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
