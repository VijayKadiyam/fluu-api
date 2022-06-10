<?php

namespace App\Http\Controllers;

use App\UserLike;
use Illuminate\Http\Request;

class UserLikesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }
    /*
     * To get all UserLike
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
        $userLikes = $request->site->user_likes()->get();

        return response()->json([
            'data'     =>  $userLikes
        ], 200);
    }

    /*
     * To store a new userLike
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'   =>  'required',
        ]);

        $userLike = new UserLike($request->all());
        $request->site->user_likes()->save($userLike);
        return response()->json([
            'data'    =>  $userLike
        ], 201);
    }

    /*
     * To view a single userLike
     *
     *@
     */
    public function show(UserLike $userLike)
    {
        $userLike->user = $userLike->user;
        $userLike->liked_user = $userLike->liked_user;
        return response()->json([
            'data'   =>  $userLike,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a userLike
     *
     *@
     */
    public function update(Request $request, UserLike $userLike)
    {
        $userLike->update($request->all());

        return response()->json([
            'data'  =>  $userLike
        ], 200);
    }

    public function destroy($id)
    {
        $userLike = UserLike::find($id);
        $userLike->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
