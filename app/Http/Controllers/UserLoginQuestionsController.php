<?php

namespace App\Http\Controllers;

use App\LoginQuestion;
use App\User;
use App\UserLoginQuestion;
use Illuminate\Http\Request;

class UserLoginQuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }

    public function masters(Request $request)
    {
        $usersController = new UsersController();
        $usersResponse = $usersController->index($request);

        $loginQuestionsController = new loginQuestionsController();
        $loginQuestionsResponse = $loginQuestionsController->index($request);

        return response()->json([
            'users'                 =>  $usersResponse->getData()->data,
            'login_questions'  =>  $loginQuestionsResponse->getData()->data,
        ], 200);
    }

    /*
     * To get all LoginQuestion
       *
     *@
     */
    public function index()
    {
        $userLoginQuestions = [];
        if (request()->user_id) {
            $userLoginQuestions = UserLoginQuestion::where('user_id', '=', request()->user_id)->with('login_question', 'user')->get();
        } else if (request()->questionId) {
            $userLoginQuestions = UserLoginQuestion::where('login_question_id', '=', request()->questionId)
                ->with('login_question', 'user')
                ->first();
        } else {
            $users = request()->site->users()->with('roles')
                ->whereHas('roles',  function ($q) {
                    $q->where('name', '!=', 'Admin')
                        ->where('name', '!=', 'Super Admin')
                        ->where('name', '!=', 'Main Admin');
                })->latest()->get();
            foreach ($users as $key => $user) {
                $userLoginQuestions = UserLoginQuestion::where('user_id', '=', $user->id)->with('login_question', 'user')->get();
            }
            // return $users;
        }
        return response()->json([
            'data'     =>  $userLoginQuestions,
            'success'   =>  true,
        ], 200);
    }

    /*
     * To store a new userLoginQuestion
     *
     *@
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'login_question_id'    =>  'required',
            'user_id'   =>  'required',
        ]);

        $userLoginQuestion = UserLoginQuestion::where('login_question_id', '=', $request->login_question_id)
            ->where('user_id', '=', $request->user_id)
            ->first();
        if ($userLoginQuestion) {
            $userLoginQuestion->update($request->all());
        } else {
            $userLoginQuestion = new UserLoginQuestion($request->all());
            $userLoginQuestion->save();
        }

        return response()->json([
            'data'    =>  $userLoginQuestion,
            'success'   =>  true,
        ], 201);
    }

    /*
     * To view a single userLoginQuestion
     *
     *@
     */
    public function show(Request $request, $id)
    {
        $userLoginQuestion = '';
        if ($request->questionId) {
            $userLoginQuestion = UserLoginQuestion::where('login_question_id', '=', $request->questionId)
                ->with('login_question', 'user')
                ->first();
        } else
            $userLoginQuestion = UserLoginQuestion::find($id)->with('login_question', 'user')->get();
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
            'data'  =>  $userLoginQuestion,
            'success'   =>  true,
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
