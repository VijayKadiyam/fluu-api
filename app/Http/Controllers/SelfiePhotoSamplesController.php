<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SelfiePhotoSample;

class SelfiePhotoSamplesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }

    /*
     * To get all SelfiepPhotoSamples
       *
     *@
     */
    public function index(Request $request)
    {
        $SelfiePhotoSample = $request->site->selfie_photo_samples()->get();

        return response()->json([
            'data'     =>   $SelfiePhotoSample
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
            'title'    =>  'required',
        ]);
        $SelfiePhotoSample = new SelfiePhotoSample($request->all());
        $request->site->selfie_photo_samples()->save($SelfiePhotoSample);

        return response()->json([
            'data'    =>   $SelfiePhotoSample
        ], 201);
    }

    /*
     * To view a single loginQuestion
     *
     *@
     */
    public function show($id)
    {
        $selfiePhotoSample = SelfiePhotoSample::find($id);
        return response()->json([
            'data'   => $selfiePhotoSample,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a loginQuestion
     *
     *@
     */
    public function update(Request $request, SelfiePhotoSample $selfiePhotoSample)
    {
        $selfiePhotoSample->update($request->all());

        return response()->json([
            'data'  => $selfiePhotoSample,
        ], 200);
    }

    public function destroy($id)
    {
        $SelfiePhotoSample = SelfiePhotoSample::find($id);
        $SelfiePhotoSample->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
