<?php

namespace App\Http\Controllers;

use App\UserNotification;
use App\Value;
use Illuminate\Http\Request;

class UserNotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }


    public function masters(Request $request)
    {
        $usersController = new UsersController();
        $usersResponse = $usersController->index($request);

        $notificationValue = Value::where('name', '=', 'NOTIFICATION')
            ->where('site_id', '=', $request->site->id)
            ->first();
        $notifications = [];
        if ($notificationValue)
            $notifications = $notificationValue->active_value_lists;

        return response()->json([
            'users'                 =>  $usersResponse->getData()->data,
            'notifications'               =>  $notifications,
        ], 200);
    }
    /*
     * To get all UserNotification
       *
     *@
     */

    public function index()
    {
        if (request()->user_id) {
            $userNotifications = UserNotification::where('user_id', '=', request()->user_id)->with('user', 'notifications')->get();
        } else {
            $users = request()->site->users()->with('roles')
                ->whereHas('roles',  function ($q) {
                    $q->where('name', '!=', 'Admin')
                        ->where('name', '!=', 'Super Admin')
                        ->where('name', '!=', 'Main Admin');
                })->latest()->get();
            foreach ($users as $key => $user) {
                $userNotifications = UserNotification::where('user_id', '=', $user->id)->with('user', 'notifications')->get();
            }
            // return $users;
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
    public function show($id)
    {
        $userNotification = UserNotification::find($id)->with('user', 'notifications')->get();

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
