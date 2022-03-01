<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserImage;
use Illuminate\Support\Facades\Storage;

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
            $userImages = UserImage::where('user_id', '=', request()->user_id)->with('user');
            if (request()->source)
                $userImages = $userImages->where('source', '=', request()->source);
            $userImages = $userImages->get();
        } else {
            $userImages = UserImage::with('user')->get();
        }

        return response()->json([
            'data'     =>  $userImages,
            'success'   =>  true,
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
            $name = $request->filename ?? 'photo.' . $file->getClientOriginalExtension();
            // $name = $name . $file->getClientOriginalExtension();;
            $imagePath = 'fluu/user_images/' . $name;
            Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

            $UserImage = UserImage::where('id', '=', $userImage_id)->first();
            $UserImage->image_path = $imagePath;
            $UserImage->update();
        }
        $referenceimage_path  = '';
        if ($request->hasFile('reference_image_path') && $userImage_id) {
            $file = $request->file('reference_image_path');
            $name = $request->filename ?? 'photo.' . $file->getClientOriginalExtension();
            // $name = $name . $file->getClientOriginalExtension();;
            $referenceimage_path= 'fluu/user_images/' . $name;
            Storage::disk('local')->put( $referenceimage_path, file_get_contents($file), 'public');

            $UserImage = UserImage::where('id', '=', $userImage_id)->first();
            $UserImage->reference_image_path =  $referenceimage_path;
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
    public function show(UserImage $userImage)
    {
        // $userImage = UserImage::find($id)->with('user')->get();
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

    public function destroy(Request $request, $id)
    {
        if($request->imagePath) {
            $userImage = UserImage::where('image_path', '=', $request->imagePath)
                ->first();
            if($userImage) {
                Storage::disk('local')->delete($userImage->image_path);
                $userImage->delete();
            }
        } else {
            $userImage = UserImage::find($id);
            // Storage::disk('local')->delete($userImage->image_path);
            $userImage->delete();
        }

        

        return response()->json([
            'message' =>  'Deleted',
        ], 204);
    }
}
