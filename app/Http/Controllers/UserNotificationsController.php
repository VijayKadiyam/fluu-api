<?php

namespace App\Http\Controllers;

use App\UserNotification;
use Illuminate\Http\Request;

class UserNotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    /*
     * To get all UserNotification
       *
     *@
     */
    public function index()
    {
        if (request()->user_id) {
            $userNotifications = UserNotification::where('user_id', '=', request()->user_id)->get();
        }

        return response()->json([
            'data'     =>  $userNotifications
        ], 200);
    }

    /*
     * To store a new user$userNotification
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'   =>  'required',
        ]);
        $userNotification = new UserNotification($request->all());
        $userNotification->save();
        return response()->json([
            'data'    =>  $userNotification
        ], 201);
    }

    /*
     * To view a single user$userNotification
     *
     *@
     */
    public function show(UserNotification $userNotification)
    {
        return response()->json([
            'data'   =>  $userNotification,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a user$userNotification
     *
     *@
     */
    public function update(Request $request, UserNotification $userNotification)
    {

        $userNotification->update($request->all());

        return response()->json([
            'data'  =>  $userNotification
        ], 200);
    }

    public function destroy($id)
    {
        $userNotification = UserNotification::find($id);
        $userNotification->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
