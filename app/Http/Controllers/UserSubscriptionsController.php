<?php

namespace App\Http\Controllers;

use App\UserSubscription;
use Illuminate\Http\Request;

class UserSubscriptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }
    /*
     * To get all UserSubscription
       *
     *@
     */

    public function index(Request $request)
    {
        $userSubscriptions = $request->site->user_subscriptions()->get();

        return response()->json([
            'data'     =>  $userSubscriptions
        ], 200);
    }

    /*
     * To store a new userSubscription
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'   =>  'required',
        ]);
        $userSubscription = new UserSubscription($request->all());
        $userSubscription->save();
        return response()->json([
            'data'    =>  $userSubscription
        ], 201);
    }

    /*
     * To view a single userSubscription
     *
     *@
     */
    public function show(UserSubscription $userSubscription)
    {
        return response()->json([
            'data'   =>  $userSubscription,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a userSubscription
     *
     *@
     */
    public function update(Request $request, UserSubscription $userSubscription)
    {
        $userSubscription->update($request->all());

        return response()->json([
            'data'  =>  $userSubscription
        ], 200);
    }

    public function destroy($id)
    {
        $userSubscription = UserSubscription::find($id);
        $userSubscription->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
