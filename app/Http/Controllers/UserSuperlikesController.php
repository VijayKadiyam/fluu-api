<?php

namespace App\Http\Controllers;

use App\UserSuperlike;
use Illuminate\Http\Request;

class UserSuperlikesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }
    /*
     * To get all UserSuperlike
       *
     *@
     */

    public function masters(Request $request)
    {
        $usersController = new UsersController();
        $usersResponse = $usersController->index($request);

        return response()->json([
            'users'                 =>  $usersResponse->getData()->data,
        ], 200);
    }

    public function index(Request $request)
    {
        $userSuperlikes = $request->site->user_superlikes()->get();

        return response()->json([
            'data'     =>  $userSuperlikes
        ], 200);
    }

    /*
     * To store a new userSuperlike
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'   =>  'required',
        ]);

        $userSuperlike = new UserSuperlike($request->all());
        $request->site->user_superlikes()->save($userSuperlike);
        return response()->json([
            'data'    =>  $userSuperlike
        ], 201);
    }

    /*
     * To view a single userSuperlike
     *
     *@
     */
    public function show(UserSuperlike $userSuperlike)
    {
        $userSuperlike->user=$userSuperlike->user;
        $userSuperlike->liked_user=$userSuperlike->liked_user;
        return response()->json([
            'data'   =>  $userSuperlike,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a userSuperlike
     *
     *@
     */
    public function update(Request $request, UserSuperlike $userSuperlike)
    {
        $userSuperlike->update($request->all());

        return response()->json([
            'data'  =>  $userSuperlike
        ], 200);
    }

    public function destroy($id)
    {
        $userSuperlike = UserSuperlike::find($id);
        $userSuperlike->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
