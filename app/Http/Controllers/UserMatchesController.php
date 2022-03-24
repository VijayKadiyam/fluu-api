<?php

namespace App\Http\Controllers;

use App\UserMatch;
use Illuminate\Http\Request;

class UserMatchesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }
    /*
     * To get all UserMatch
       *
     *@
     */

    public function index(Request $request)
    {
        $userMatches = $request->site->user_matches()->get();

        return response()->json([
            'data'     =>  $userMatches
        ], 200);
    }

    /*
     * To store a new userMatch
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'   =>  'required',
        ]);
        $userMatch = new UserMatch($request->all());
        $userMatch->save();
        return response()->json([
            'data'    =>  $userMatch
        ], 201);
    }

    /*
     * To view a single userMatch
     *
     *@
     */
    public function show(UserMatch $userMatch)
    {
        return response()->json([
            'data'   =>  $userMatch,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a userMatch
     *
     *@
     */
    public function update(Request $request, UserMatch $userMatch)
    {
        $userMatch->update($request->all());

        return response()->json([
            'data'  =>  $userMatch
        ], 200);
    }

    public function destroy($id)
    {
        $userMatch = UserMatch::find($id);
        $userMatch->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
