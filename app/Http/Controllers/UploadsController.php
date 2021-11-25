<?php

namespace App\Http\Controllers;

use App\PscInspection;
use App\PscInspectionDeficiency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\UserProgramTask;
use App\UserProgramTaskDocument;

class UploadsController extends Controller
{
  public function uploadUserImage(Request $request)
  {
    $request->validate([
      'userid'        => 'required',
    ]);

    $imagePath = '';
    if ($request->hasFile('imagepath')) {
      $file = $request->file('imagepath');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'users/' .  $request->userid . '/' . $name;
      Storage::disk('local')->put($imagePath, file_get_contents($file), 'public');

      $user = User::where('id', '=', request()->userid)->first();
      $user->image_path = $imagePath;
      $user->update();

      $user->roles = $user->roles;
      $user->sites = $user->sites;

      return response()->json([
        'data'  =>  $user,
        'message' =>  "User is Logged in Successfully",
        'success' =>  true
      ], 200);
    }

    return response()->json([
      'data'  => [
        'image_path'  =>  $imagePath
      ],
      'success' =>  true
    ]);
  }

  public function uploadUserProgramTaskDocumentImage(Request $request)
  {
    $request->validate([
      'id'        => 'required',
    ]);

    $documentImagePath = '';
    if ($request->hasFile('document_path')) {
      $file = $request->file('document_path');
      $name = $request->filename ?? 'photo.';
      $name = $name . $file->getClientOriginalExtension();;
      $documentImagePath = 'user-program-task-documents/' .  $request->id . '/' . $name;
      Storage::disk('local')->put($documentImagePath, file_get_contents($file), 'public');

      $group = UserProgramTaskDocument::where('id', '=', request()->id)->first();
      $group->document_path = $documentImagePath;
      $group->update();

      return response()->json([
        'data'  =>  $group,
        'message' =>  "User Program Task Document Image upload Successfully",
        'success' =>  true
      ], 200);
    }

    return response()->json([
      'data'  => [
        'image_path'  =>  $documentImagePath
      ],
      'success' =>  true
    ]);
  }

  public function uploadUserProgramTaskImagePath(Request $request)
  {
    $request->validate([
      'user_program_task_id'        => 'required',
    ]);

    $imagePath1 = '';
    if ($request->hasFile('imagepath1')) {
      $file = $request->file('imagepath1');
      $name = $request->filename ?? 'imagepath1.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath1 = 'user-program-task/' .  $request->user_program_task_id . '/' . $name;
      Storage::disk('local')->put($imagePath1, file_get_contents($file), 'public');

      $userProgramTask = UserProgramTask::where('id', '=', request()->user_program_task_id)->first();
      $userProgramTask->imagepath1 = $imagePath1;
      $userProgramTask->update();

      return response()->json([
        'data'  =>  $userProgramTask,
        'message' =>  "User Program Task Image1 upload Successfully",
        'success' =>  true
      ], 200);
    }

    $imagePath2 = '';
    if ($request->hasFile('imagepath2')) {
      $file = $request->file('imagepath2');
      $name = $request->filename ?? 'imagepath2.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath2 = 'user-program-task/' .  $request->user_program_task_id . '/' . $name;
      Storage::disk('local')->put($imagePath2, file_get_contents($file), 'public');

      $userProgramTask = UserProgramTask::where('id', '=', request()->user_program_task_id)->first();
      $userProgramTask->imagepath2 = $imagePath2;
      $userProgramTask->update();

      return response()->json([
        'data'  =>  $userProgramTask,
        'message' =>  "User Program Task Image2 upload Successfully",
        'success' =>  true
      ], 200);
    }

    $imagePath3 = '';
    if ($request->hasFile('imagepath3')) {
      $file = $request->file('imagepath3');
      $name = $request->filename ?? 'imagepath3.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath3 = 'user-program-task/' .  $request->user_program_task_id . '/' . $name;
      Storage::disk('local')->put($imagePath3, file_get_contents($file), 'public');

      $userProgramTask = UserProgramTask::where('id', '=', request()->user_program_task_id)->first();
      $userProgramTask->imagepath3 = $imagePath3;
      $userProgramTask->update();

      return response()->json([
        'data'  =>  $userProgramTask,
        'message' =>  "User Program Task Image3 upload Successfully",
        'success' =>  true
      ], 200);
    }

    $imagePath4 = '';
    if ($request->hasFile('imagepath4')) {
      $file = $request->file('imagepath4');
      $name = $request->filename ?? 'imagepath4.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath4 = 'user-program-task/' .  $request->user_program_task_id . '/' . $name;
      Storage::disk('local')->put($imagePath4, file_get_contents($file), 'public');

      $userProgramTask = UserProgramTask::where('id', '=', request()->user_program_task_id)->first();
      $userProgramTask->imagepath4 = $imagePath4;
      $userProgramTask->update();

      return response()->json([
        'data'  =>  $userProgramTask,
        'message' =>  "User Program Task Image4 upload Successfully",
        'success' =>  true
      ], 200);
    }

    return response()->json([
      'data'  => [
        'image_path1'  =>  $imagePath1,
        'image_path2'  =>  $imagePath2,
        'image_path3'  =>  $imagePath3,
        'image_path4'  =>  $imagePath4
      ],
      'success' =>  true
    ]);
  }

  public function uploadPscInspectionReport1(Request $request)
  {
    $request->validate([
      'psc_inspection_id'        => 'required',
    ]);

    $reportpath = '';
    if ($request->hasFile('reportpath')) {
      $file = $request->file('reportpath');
      $name = $request->filename ?? 'reportpath.';
      $name = $name . $file->getClientOriginalExtension();;
      $reportpath = 'psc-inspection/' .  $request->psc_inspection_id . '/' . $name;
      Storage::disk('local')->put($reportpath, file_get_contents($file), 'public');

      $PscInspection = PscInspection::where('id', '=', request()->psc_inspection_id)->first();
      $PscInspection->reportpath = $reportpath;
      $PscInspection->update();

      return response()->json([
        'data'  =>  $PscInspection,
        'message' =>  "User Program Task Image1 upload Successfully",
        'success' =>  true
      ], 200);
    }


    return response()->json([
      'data'  => [
        'reportpath'  =>  $reportpath,
      ],
      'success' =>  true
    ]);
  }

  public function uploadPscInspectionReport(Request $request)
  {
    $request->validate([
      'psc_inspection_id'        => 'required',
    ]);

    $reportpath = '';
    if ($request->hasFile('reportpath')) {
      $file = $request->file('reportpath');
      $name = $request->filename ?? 'reportpath.';
      $name = $name . $file->getClientOriginalExtension();;
      $reportpath = 'psc-inspection/' .  $request->psc_inspection_id . '/' . $name;
      Storage::disk('local')->put($reportpath, file_get_contents($file), 'public');

      $PscInspection = PscInspection::where('id', '=', request()->psc_inspection_id)->first();
      $PscInspection->reportpath = $reportpath;
      $PscInspection->update();
    }

    for ($i = 0; $i < $request->evidence_count; $i++) {
      $f_name = "evidencepath" . $i;
      $deficiency_id = "deficiency_id" . $i;
      if ($request->hasFile("evidencepath" . $i)) {
        $file = $request->file('evidencepath' . $i);
        $name = $request->filename ?? "$f_name.";
        $name = $name . $file->getClientOriginalExtension();;
        $evidencepath = 'psc-inspection/' .  $request->psc_inspection_id . '/psc-inspection-details/' . $name;
        Storage::disk('local')->put($evidencepath, file_get_contents($file), 'public');

        $PscInspectionDeficiency = PscInspectionDeficiency::where('id', '=', request()->$deficiency_id)->first();
        $PscInspectionDeficiency->evidencepath = $evidencepath;
        $PscInspectionDeficiency->update();
      }
    }

    return response()->json([
      'data'  => [
        'reportpath'  =>  $reportpath,
        'evidence_count' => $request->evidence_count
      ],
      'success' =>  true
    ]);
  }
}
