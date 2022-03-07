<?php

namespace App\Http\Controllers;

use App\LoginQuestion;
use Illuminate\Http\Request;

class LoginQuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }

    /*
     * To get all LoginQuestion
       *
     *@
     */
    public function index(Request $request)
    {
        $loginQuestions = $request->site->login_questions()->get();

        return response()->json([
            'data'     =>  $loginQuestions
        ], 200);
    }

    /*
     * To store a new loginQuestion
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'description'    =>  'required',
            'is_active'   =>  'required',
            'is_mcq'   =>  'required',

        ]);
        $loginQuestion = new LoginQuestion($request->all());
        $request->site->login_questions()->save($loginQuestion);

        return response()->json([
            'data'    =>  $loginQuestion
        ], 201);
    }

    /*
     * To view a single loginQuestion
     *
     *@
     */
    public function show(LoginQuestion $loginQuestion)
    {
        return response()->json([
            'data'   =>  $loginQuestion,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a loginQuestion
     *
     *@
     */
    public function update(Request $request, LoginQuestion $loginQuestion)
    {

        $loginQuestion->update($request->all());

        return response()->json([
            'data'  =>  $loginQuestion
        ], 200);
    }

    public function destroy($id)
    {
        $loginQuestion = LoginQuestion::find($id);
        $loginQuestion->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
