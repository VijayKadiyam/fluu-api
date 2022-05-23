<?php

namespace App\Http\Controllers;

use App\LoginQuestion;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\UserImage;
use App\SelfiePhotoSample;
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
      $imagePath = 'fluu/users/selfies/' .  $request->userid . '/' . $name;
      Storage::disk('s3')->put($imagePath, file_get_contents($file), 'public');

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
      $imagePath = 'fluu/users/galleries/' .  $request->userid . '/' . $name;
      Storage::disk('s3')->put($imagePath, file_get_contents($file), 'public');

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
      $imagePath = 'fluu/users/galleries/' .  $request->userid . '/' . $name;
      Storage::disk('s3')->put($imagePath, file_get_contents($file), 'public');

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
      $imagePath = 'fluu/users/galleries/' .  $request->userid . '/' . $name;
      Storage::disk('s3')->put($imagePath, file_get_contents($file), 'public');

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
      $imagePath = 'fluu/users/galleries/' .  $request->userid . '/' . $name;
      Storage::disk('s3')->put($imagePath, file_get_contents($file), 'public');

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
      $imagePath = 'fluu/users/voices/' .  $request->userid . '/' . $name;
      Storage::disk('s3')->put($imagePath, file_get_contents($file), 'public');

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
      $imagePath = 'fluu/user-stories/images/' .  $request->userid . '/' . $name;
      Storage::disk('s3')->put($imagePath, file_get_contents($file), 'public');

      $UserStory = UserStory::where('id', '=', request()->userid)->first();
      $UserStory->image_path = $imagePath;
      $UserStory->update();
    }

    if ($request->hasFile('video_path')) {
      $file = $request->file('video_path');
      $name = $request->filename ?? 'video.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'fluu/user-stories/video/' .  $request->userid . '/' . $name;
      Storage::disk('s3')->put($imagePath, file_get_contents($file), 'public');

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
      $name = $request->filename ?? 'photo.' . time() . '.' . $file->getClientOriginalExtension();
      $banner_path_1 = 'fluu/banner/' .  $request->settingid . '/' . $name;
      Storage::disk('s3')->put($banner_path_1, file_get_contents($file), 'public');

      $setting = Setting::where('id', '=', request()->settingid)->first();
      $setting->banner_path_1 = $banner_path_1;
      $setting->update();
    }

    $banner_path_2 = '';
    if ($request->hasFile('banner_path_2')) {
      $file = $request->file('banner_path_2');
      $name = $request->filename ?? 'photo.' . time() . '.' . $file->getClientOriginalExtension();
      $banner_path_2 = 'fluu/banner/' .  $request->settingid . '/' . $name;
      Storage::disk('s3')->put($banner_path_2, file_get_contents($file), 'public');

      $setting = Setting::where('id', '=', request()->settingid)->first();
      $setting->banner_path_2 = $banner_path_2;
      $setting->update();
    }

    $banner_path_3 = '';
    if ($request->hasFile('banner_path_3')) {
      $file = $request->file('banner_path_3');
      $name = $request->filename ?? 'photo.' . time() . '.' . $file->getClientOriginalExtension();
      $banner_path_3 = 'fluu/banner/' .  $request->settingid . '/' . $name;
      Storage::disk('s3')->put($banner_path_3, file_get_contents($file), 'public');

      $setting = Setting::where('id', '=', request()->settingid)->first();
      $setting->banner_path_3 = $banner_path_3;
      $setting->update();
    }

    $logo_path = '';
    if ($request->hasFile('logo_path')) {
      $file = $request->file('logo_path');
      $name = $request->filename ?? 'photo.' . time() . '.' . $file->getClientOriginalExtension();
      $logo_path = 'fluu/logo/' .  $request->settingid . '/' . $name;
      Storage::disk('s3')->put($logo_path, file_get_contents($file), 'public');

      $setting = Setting::where('id', '=', request()->settingid)->first();
      $setting->logo_path = $logo_path;
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

  public function uploaduser_images(Request $request)
  {
    $request->validate([
      'userid'        => 'required',
    ]);

    $imagePath = '';
    if ($request->hasFile('image_path')) {
      $file = $request->file('image_path');
      $name = $request->filename ?? 'photo.' . time() . '.' . $file->getClientOriginalExtension();
      $imagePath = 'fluu/user_images/' . $name;
      Storage::disk('s3')->put($imagePath, file_get_contents($file), 'public');

      $data = [
        'user_id' =>  $request->userid,
        'source' => $request->source,
        'image_path'  =>  $imagePath,
      ];
      $UserImage = new UserImage($data);
      $UserImage->save();

      if ($request->source == 'Profile' || $request->source == 'Gallery') {
        $userImages = UserImage::where('user_id', '=', $request->userid)
            ->where('source', '=', 'Gallery')
            ->get();
        if(sizeof($userImages) == 1) {
            $user = User::find($request->userid);
            $user->selfie_image_path = $imagePath;
            $user->update();
        }  
      }

      // if ($request->source == 'Profile') {
      //   $user = User::find($request->userid);
      //   $user->selfie_image_path = $imagePath;
      //   $user->update();
      // }
    }
    $referenceimage_path = '';
    if ($request->hasFile('reference_image_path')) {
      $file = $request->file('reference_image_path');
      $name = $request->filename ?? 'photo.' . time() . '.' . $file->getClientOriginalExtension();
      // $name = $name . $file->getClientOriginalExtension();;
      $referenceimage_path = 'fluu/user_images/' . $name;
      Storage::disk('s3')->put($referenceimage_path, file_get_contents($file), 'public');

      // $data = [
      //   'user_id' =>  $request->userid,
      //   'source' => $request->source,
      //   'reference_image_path' => $referenceimage_path,
      // ];
      // $UserImage = new UserImage($data);
      // $UserImage->save();
      $userImage =  UserImage::where('user_id', '=', $request->userid)->first();
      $userImage->reference_image_path = $referenceimage_path;
      $userImage->update();
    }
    return response()->json([
      'data'  => [
        'image_path'  =>  $imagePath,
        'reference_image_path'=>$referenceimage_path
      ],
      'success' =>  true
    ]);
  }
  public function uploadSelfiePhotoSample(Request $request)
  {
    $request->validate([
      'selfie_photo_sample_id' => 'required',
      'image_path'        => 'required',
    ]);

    $imagePath = '';
    if ($request->hasFile('image_path')) {
      $file = $request->file('image_path');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'fluu/selfie_photo_samples/images/' .  $request->selfie_photo_sample_id . '/' . $name;
      Storage::disk('s3')->put($imagePath, file_get_contents($file), 'public');

      $selfiephotoSamples =  SelfiePhotoSample::where('id', '=', $request->selfie_photo_sample_id)->first();
      $selfiephotoSamples->image_path = $imagePath;
      $selfiephotoSamples->update();
    }



    return response()->json([
      'data'  => [
        'image_path'  =>  $imagePath
      ],
      'success' =>  true
    ]);
  }
  public function uploadLoginQuestionImage(Request $request)
  {
    $request->validate([
      'login_question_id' => 'required',


    ]);

  $image_option_1 = '';
  if ($request->hasFile('image_option_1')) {
    $file = $request->file('image_option_1');
    $name = $request->filename ?? 'photo.';
    $name = $name . $file->getClientOriginalExtension();;
    $image_option_1 = 'fluu/loginquestion/images/' .  $request->login_question_id . '/' . $name;
    Storage::disk('s3')->put($image_option_1, file_get_contents($file), 'public');

    $loginquestion = LoginQuestion::where('id', '=', request()->login_question_id)->first();
    $loginquestion ->image_option_1 = $image_option_1;
    $loginquestion ->update();
  }

  $image_option_2 = '';
  if ($request->hasFile('image_option_2')) {
    $file = $request->file('image_option_2');
    $name = $request->filename ?? 'photo.';
    $name = $name . $file->getClientOriginalExtension();;
    $image_option_2  = 'fluu/loginquestion/images/' .  $request->login_question_id . '/' . $name;
    Storage::disk('s3')->put($image_option_2 , file_get_contents($file), 'public');

    $loginquestion  = LoginQuestion::where('id', '=', request()->login_question_id)->first();
    $loginquestion ->image_option_2 = $image_option_2;
    $loginquestion ->update();
  }

  $image_option_3 = '';
  if ($request->hasFile('image_option_3')) {
    $file = $request->file('image_option_3');
    $name = $request->filename ?? 'photo.';
    $name = $name . $file->getClientOriginalExtension();;
   $image_option_3 = 'fluu/loginquestion/images/' .  $request->login_question_id . '/' . $name;
    Storage::disk('s3')->put($image_option_3, file_get_contents($file), 'public');

    $loginquestion  = LoginQuestion::where('id', '=', request()->login_question_id)->first();
    $loginquestion->image_option_3 =$image_option_3;
    $loginquestion->update();
  }

  $image_option_4 = '';
  if ($request->hasFile('image_option_4')) {
    $file = $request->file('image_option_4');
    $name = $request->filename ?? 'photo.';
    $name = $name . $file->getClientOriginalExtension();;
   $image_option_4 = 'fluu/loginquestion/images/' .  $request->login_question_id . '/' . $name;
    Storage::disk('s3')->put($image_option_4, file_get_contents($file), 'public');

    $loginquestion  =LoginQuestion::where('id', '=', request()->login_question_id)->first();
    $loginquestion ->image_option_4 =$image_option_4;
    $loginquestion->update();
  }


    return response()->json([
      'data'  => [
        'image_option_1'  =>  $image_option_1,
        'image_option_2' =>   $image_option_2,
        'image_option_3'  =>  $image_option_3,
        'image_option_4' =>   $image_option_4,
      ],
      'success' =>  true
    ]);
  }
}
