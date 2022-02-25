<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\UserImage;
use App\UserStory;
use App\UserLoginQuestion;

class UploadsController extends Controller
{
  public function uploadUserImage(Request $request)
  {
    $request->validate([
      'userid'        => 'required',
    ]);

    $imagePath = '';
    if ($request->hasFile('selfie_image_path')) {
      $file = $request->file('selfie_image_path');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'users/selfies/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

      $user = User::where('id', '=', request()->userid)->first();
      $user->selfie_image_path = $imagePath;
      $user->update();

      $user->roles = $user->roles;
      $user->sites = $user->sites;
    }
    if ($request->hasFile('gallery_image1_path')) {
      $file = $request->file('gallery_image1_path');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'users/galleries/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

      $user = User::where('id', '=', request()->userid)->first();
      $user->gallery_image1_path = $imagePath;
      $user->update();

      $user->roles = $user->roles;
      $user->sites = $user->sites;
    }
    if ($request->hasFile('gallery_image2_path')) {
      $file = $request->file('gallery_image2_path');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'users/galleries/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

      $user = User::where('id', '=', request()->userid)->first();
      $user->gallery_image2_path = $imagePath;
      $user->update();

      $user->roles = $user->roles;
      $user->sites = $user->sites;
    }
    if ($request->hasFile('gallery_image3_path')) {
      $file = $request->file('gallery_image3_path');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'users/galleries/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

      $user = User::where('id', '=', request()->userid)->first();
      $user->gallery_image3_path = $imagePath;
      $user->update();

      $user->roles = $user->roles;
      $user->sites = $user->sites;
    }
    if ($request->hasFile('gallery_image4_path')) {
      $file = $request->file('gallery_image4_path');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'users/galleries/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

      $user = User::where('id', '=', request()->userid)->first();
      $user->gallery_image4_path = $imagePath;
      $user->update();

      $user->roles = $user->roles;
      $user->sites = $user->sites;
    }
    if ($request->hasFile('voice_clip_path')) {
      $file = $request->file('voice_clip_path');
      $name = $request->filename ?? 'audio.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'users/voices/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

      $user = User::where('id', '=', request()->userid)->first();
      $user->voice_clip_path = $imagePath;
      $user->update();

      $user->roles = $user->roles;
      $user->sites = $user->sites;
    }

    return response()->json([
      'data'  => [
        'image_path'  =>  $imagePath
      ],
      'success' =>  true
    ]);
  }

  public function uploadUserStory(Request $request)
  {
    $request->validate([
      'userid'        => 'required',
    ]);

    $imagePath = '';
    if ($request->hasFile('image_path')) {
      $file = $request->file('image_path');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'user-stories/images/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

      $UserStory = UserStory::where('id', '=', request()->userid)->first();
      $UserStory->image_path = $imagePath;
      $UserStory->update();
    }

    if ($request->hasFile('video_path')) {
      $file = $request->file('video_path');
      $name = $request->filename ?? 'video.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'user-stories/video/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

      $UserStory = UserStory::where('id', '=', request()->userid)->first();
      $UserStory->video_path = $imagePath;
      $UserStory->update();
    }

    return response()->json([
      'data'  => [
        'image_path'  =>  $imagePath
      ],
      'success' =>  true
    ]);
  }
  public function uploadBannerImage(Request $request)
  {
    $request->validate([
      'settingid'        => 'required',
    ]);

    $banner_path_1 = '';
    if ($request->hasFile('banner_path_1')) {
      $file = $request->file('banner_path_1');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $banner_path_1 = 'banner/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($banner_path_1, file_get_contents($file), 'public');

      $setting = UserStory::where('id', '=', request()->userid)->first();
      $setting->banner_path_1 = $banner_path_1;
      $setting->update();
    }

    $banner_path_2 = '';
    if ($request->hasFile('banner_path_2')) {
      $file = $request->file('banner_path_2');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $banner_path_2 = 'banner/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($banner_path_2, file_get_contents($file), 'public');

      $setting = UserStory::where('id', '=', request()->userid)->first();
      $setting->banner_path_2 = $banner_path_2;
      $setting->update();
    }

    $banner_path_3 = '';
    if ($request->hasFile('banner_path_3')) {
      $file = $request->file('banner_path_3');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $banner_path_3 = 'banner/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($banner_path_3, file_get_contents($file), 'public');

      $setting = UserStory::where('id', '=', request()->userid)->first();
      $setting->banner_path_3 = $banner_path_3;
      $setting->update();
    }


    return response()->json([
      'data'  => [
        'banner_path_1'  =>  $banner_path_1,
        'banner_path_2'  =>  $banner_path_2,
        'banner_path_3'  =>  $banner_path_3,
      ],
      'success' =>  true
    ]);
  }
  
  public function uploaduser_images(Request $request){
    $request->validate([
      'userid'        => 'required',
    ]);

    $imagePath = '';
    if ($request->hasFile('image_path')) {
      $file = $request->file('image_path');
      $name = $request->filename ?? 'photo.'.time(). '.'.$file->getClientOriginalExtension();
      // $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'user-images/images/' . $name;
      Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

      $data = [
        'user_id' =>  $request->userid,
        'source' => $request->source,
        'image_path'  =>  $imagePath,
      ];
      $UserImage = new UserImage($data);
      $UserImage->save();

      if($request->source == 'Profile') {
        $user = User::find($request->userid);
        $user->selfie_image_path = $imagePath;
        $user->update();
      }
    } 
    $referenceimage_path = '';
    if ($request->hasFile('Reference_image_path')) {
      $file = $request->file('Reference_image_path');
      $name = $request->filename ?? 'photo.'.time(). '.'.$file->getClientOriginalExtension();
      // $name = $name . $file->getClientOriginalExtension();;
      $referenceimage_path = 'user-images/images/' . $name;
      Storage::disk('local')->put($referenceimage_path, file_get_contents($file), 'public');

      $data = [
        'user_id' =>  $request->userid,
        'source' => $request->source,
        'image_path'  =>  $imagePath,
        'Reference_image_path'=> $referenceimage_path,
      ];
      $UserImage = new UserImage($data);
      $UserImage->save();

      if($request->source == 'Profile') {
        $user = User::find($request->userid);
        $user->selfie_image_path =$referenceimage_path;
        $user->update();
      }
    } 
  }
  public function uploadImage_option(Request $request)
 {
  $request->validate([
    'login_question_id'=> 'required',
    'userid'         => 'required',

  ]);

  $Image_option_1 = '';
  if ($request->hasFile('Image_option_1')) {
    $file = $request->file('Image_option_1');
    $name = $request->filename ?? 'photo.';
    $name = $name . $file->getClientOriginalExtension();;
    $Image_option_1 = 'userloginquestions/images/' .  $request->userid . '/' . $name;
    Storage::disk('local')->put($Image_option_1, file_get_contents($file), 'public');

    $userloginquestions = UserLoginQuestion::where('id', '=', request()->userid)->first();
    $userloginquestions ->Image_option_1 = $Image_option_1;
    $userloginquestions ->update();
  }

  $Image_option_2 = '';
  if ($request->hasFile('Image_option_2')) {
    $file = $request->file('Image_option_2');
    $name = $request->filename ?? 'photo.';
    $name = $name . $file->getClientOriginalExtension();;
    $Image_option_2  = 'userloginquestions/images/' .  $request->userid . '/' . $name;
    Storage::disk('local')->put($Image_option_2 , file_get_contents($file), 'public');

    $userloginquestions  = UserLoginQuestion::where('id', '=', request()->userid)->first();
    $userloginquestions ->Image_option_2 = $Image_option_2;
    $userloginquestions ->update();
  }

  $Image_option_3 = '';
  if ($request->hasFile('Image_option_3')) {
    $file = $request->file('Image_option_3');
    $name = $request->filename ?? 'photo.';
    $name = $name . $file->getClientOriginalExtension();;
   $Image_option_3 = 'userloginquestions/images/' .  $request->userid . '/' . $name;
    Storage::disk('local')->put($Image_option_3, file_get_contents($file), 'public');

    $userloginquestions  = UserLoginQuestion::where('id', '=', request()->userid)->first();
    $userloginquestions->Image_option_3 =$Image_option_3;
    $userloginquestions->update();
  }

  $Image_option_4 = '';
  if ($request->hasFile('Image_option_4')) {
    $file = $request->file('Image_option_4');
    $name = $request->filename ?? 'photo.';
    $name = $name . $file->getClientOriginalExtension();;
   $Image_option_4 = 'userloginquestions/images/' .  $request->userid . '/' . $name;
    Storage::disk('local')->put($Image_option_4, file_get_contents($file), 'public');

    $userloginquestions  = UserLoginQuestion::where('id', '=', request()->userid)->first();
    $userloginquestions ->Image_option_4 =$Image_option_4;
    $userloginquestions->update();
  }


  return response()->json([
    'data'  => [
      'Image_option_1'  =>  $Image_option_1,
      'Image_option_2' =>   $Image_option_2,
      'Image_option_3'  =>  $Image_option_3,
      'Image_option_4' =>   $Image_option_4,
    ],
    'success' =>  true
  ]);
 }
}
