<?php

namespace App\Http\Controllers;

use App\LoginQuestion;
use App\UserLoginQuestion;
use Illuminate\Http\Request;

class UserLoginQuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    /*
     * To get all LoginQuestion
       *
     *@
     */
    public function index()
    {
        if (request()->user_id) {
            $userLoginQuestions = UserLoginQuestion::where('user_id', '=', request()->user_id)->get();
        }
        return response()->json([
            'data'     =>  $userLoginQuestions
        ], 200);
    }

    /*
     * To store a new userLoginQuestion
     *
     *@
     */
    public function store(Request $request, LoginQuestion $loginQuestion)
    {
        $request->validate([
            'login_question_id'    =>  'required',
            'user_id'   =>  'required',
        ]);
        $userLoginQuestion = new UserLoginQuestion($request->all());
        $userLoginQuestion->save();
        return response()->json([
            'data'    =>  $userLoginQuestion
        ], 201);
    }

    /*
     * To view a single userLoginQuestion
     *
     *@
     */
    public function show(UserLoginQuestion $userLoginQuestion)
    {
        return response()->json([
            'data'   =>  $userLoginQuestion,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a userLoginQuestion
     *
     *@
     */
    public function update(Request $request, UserLoginQuestion $userLoginQuestion)
    {

        $userLoginQuestion->update($request->all());

        return response()->json([
            'data'  =>  $userLoginQuestion
        ], 200);
    }

    public function destroy($id)
    {
        $userLoginQuestion = UserLoginQuestion::find($id);
        $userLoginQuestion->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
