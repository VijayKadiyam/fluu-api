<?php

namespace App\Http\Controllers;

use App\UserSwipe;
use Illuminate\Http\Request;

class UserSwipesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }
    /*
     * To get all UserSwipe
       *
     *@
     */

    public function index(Request $request)
    {
        $userSwipes = $request->site->user_swipes()->get();

        return response()->json([
            'data'     =>  $userSwipes
        ], 200);
    }

    /*
     * To store a new userSwipe
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'   =>  'required',
        ]);
        $userSwipe = new UserSwipe($request->all());
        $userSwipe->save();
        return response()->json([
            'data'    =>  $userSwipe
        ], 201);
    }

    /*
     * To view a single userSwipe
     *
     *@
     */
    public function show(UserSwipe $userSwipe)
    {
        return response()->json([
            'data'   =>  $userSwipe,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a userSwipe
     *
     *@
     */
    public function update(Request $request, UserSwipe $userSwipe)
    {
        $userSwipe->update($request->all());

        return response()->json([
            'data'  =>  $userSwipe
        ], 200);
    }

    public function destroy($id)
    {
        $userSwipe = UserSwipe::find($id);
        $userSwipe->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
