<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }
    /*
     * To get all Subscription
       *
     *@
     */

    public function index(Request $request)
    {
        $subscriptions = $request->site->subscriptions()->get();

        return response()->json([
            'data'     =>  $subscriptions
        ], 200);
    }

    /*
     * To store a new subscription
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'subscription_name'   =>  'required',
        ]);

        $subscription = new Subscription($request->all());
        $request->site->subscriptions()->save($subscription);
        return response()->json([
            'data'    =>  $subscription
        ], 201);
    }

    /*
     * To view a single subscription
     *
     *@
     */
    public function show(Subscription $subscription)
    {
        $subscription->user = $subscription->user;
        $subscription->liked_user = $subscription->liked_user;
        return response()->json([
            'data'   =>  $subscription,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a subscription
     *
     *@
     */
    public function update(Request $request, Subscription $subscription)
    {
        $subscription->update($request->all());

        return response()->json([
            'data'  =>  $subscription
        ], 200);
    }

    public function destroy($id)
    {
        $subscription = Subscription::find($id);
        $subscription->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
