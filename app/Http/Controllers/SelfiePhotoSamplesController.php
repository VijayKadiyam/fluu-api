<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SelfiePhotoSamples;
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
        $selfiephotoSamples = $request->site->selfie_photo_samples()->get();

        return response()->json([
            'data'     =>   $selfiephotoSamples
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
         $selfiephotoSamples = new SelfiePhotoSamples($request->all());
        $request->site->selfie_photo_samples()->save($selfiephotoSamples);

        return response()->json([
            'data'    =>   $selfiephotoSamples
        ], 201);
    }

    /*
     * To view a single loginQuestion
     *
     *@
     */
    public function show($id)
    {
        $selfiephotoSample=SelfiePhotoSamples::find($id);
      //  dd($selfiephotoSample);
        return response()->json([
            'data'   => $selfiephotoSample,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a loginQuestion
     *
     *@
     */
    public function update(Request $request,$id)
    {// dd($id);
        $selfiephotoSample=SelfiePhotoSamples::find($id)->update($request->all());
       // dd($selfiephotoSample);

        return response()->json([
            'data'  => $selfiephotoSample,
            
        ], 200);
    }

    public function destroy($id)
    {
         $selfiephotoSamples = SelfiePhotoSamples::find($id);
         $selfiephotoSamples->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
