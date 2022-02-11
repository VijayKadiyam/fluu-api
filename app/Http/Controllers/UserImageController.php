<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserImage;

class UserImageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }

    public function masters(Request $request)
    {
        $usersController = new UsersController();
        $usersResponse = $usersController->index($request);

        return response()->json([
            'users'                 =>  $usersResponse->getData()->data,
        ], 200);
    }
    /*
     * To get all UserImage
       *
     *@
     */
    public function index()
    {
        if (request()->user_id) {
            $userStories = UserImage::where('user_id', '=', request()->user_id)->with('user')->get();
        } else {
            $userStories = UserImage::with('user')->get();
        }

        return response()->json([
            'data'     =>  $userStories
        ], 200);
    }

    /*
     * To store a new userImage
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'   =>  'required',
        ]);
        $userImage = new UserImage($request->all());
        $userImage->save();

        $userImage_id = $userImage->id;
        $imagePath = '';
        if ($request->hasFile('image_path') && $userImage_id) {
            $file = $request->file('image_path');
            $name = $request->filename ?? 'photo.';
            $name = $name . $file->getClientOriginalExtension();;
            $imagePath = 'user-images/images/' .  $userImage_id . '/' . $name;
            Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

            $UserImage = UserImage::where('id', '=', $userImage_id)->first();
            $UserImage->image_path = $imagePath;
            $UserImage->update();
        }

        return response()->json([
            'data'    =>  $userImage
        ], 201);
    }

    /*
     * To view a single userImage
     *
     *@
     */
    public function show($id)
    {
        $userImage = UserImage::find($id)->with('user')->get();
        return response()->json([
            'data'   =>  $userImage,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a userImage
     *
     *@
     */
    public function update(Request $request, UserImage $userImage)
    {

        $userImage->update($request->all());

        return response()->json([
            'data'  =>  $userImage
        ], 200);
    }

    public function destroy($id)
    {
        $userImage = UserImage::find($id);
        $userImage->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
