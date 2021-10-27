<?php

namespace App\Http\Controllers;

use App\ViqChapter;
use Illuminate\Http\Request;

class ViqChaptersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'site']);
    }

    /*
     * To get all ViqChapter
       *
     *@
     */
    public function index()
    {
        $viqChapters = ViqChapter::get();

        return response()->json([
            'data'     =>  $viqChapters
        ], 200);
    }

    /*
     * To store a new viqChapter
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'serial_no'    =>  'required',
            'chapter_name'   =>  'required',
        ]);
        $viqChapter = new ViqChapter($request->all());
        $request->site->viq_chapters()->save($viqChapter);

        return response()->json([
            'data'    =>  $viqChapter
        ], 201);
    }

    /*
     * To view a single viqChapter
     *
     *@
     */
    public function show(ViqChapter $viqChapter)
    {
        return response()->json([
            'data'   =>  $viqChapter,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a viqChapter
     *
     *@
     */
    public function update(Request $request, ViqChapter $viqChapter)
    {

        $viqChapter->update($request->all());

        return response()->json([
            'data'  =>  $viqChapter
        ], 200);
    }

    public function destroy($id)
    {
        $viqChapter = ViqChapter::find($id);
        $viqChapter->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
