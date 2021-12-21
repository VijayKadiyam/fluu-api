<?php

namespace App\Http\Controllers;

use App\UserStory;
use Illuminate\Http\Request;

class UserStoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    /*
     * To get all UserStory
       *
     *@
     */
    public function index()
    {
        if (request()->user_id) {
            $userStories = UserStory::where('user_id', '=', request()->user_id)->get();
        }

        return response()->json([
            'data'     =>  $userStories
        ], 200);
    }

    /*
     * To store a new userStory
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'   =>  'required',
        ]);
        $userStory = new UserStory($request->all());
        $userStory->save();
        return response()->json([
            'data'    =>  $userStory
        ], 201);
    }

    /*
     * To view a single userStory
     *
     *@
     */
    public function show(UserStory $userStory)
    {
        return response()->json([
            'data'   =>  $userStory,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a userStory
     *
     *@
     */
    public function update(Request $request, UserStory $userStory)
    {

        $userStory->update($request->all());

        return response()->json([
            'data'  =>  $userStory
        ], 200);
    }

    public function destroy($id)
    {
        $userStory = UserStory::find($id);
        $userStory->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
