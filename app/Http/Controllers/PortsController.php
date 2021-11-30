<?php

namespace App\Http\Controllers;

use App\Port;
use Illuminate\Http\Request;

class PortsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['site']);
    }

    public function index(Request $request)
    {
        $count = 0;
        if ($request->search) {
            $ports = request()->site->ports()
                ->where('name', 'LIKE', '%' . $request->search . '%')
                ->get();
            $count = $ports->count();
        } else if (request()->page && request()->rowsPerPage) {
            $ports = request()->site->ports();
            $count = $ports->count();
            $ports = $ports->paginate(request()->rowsPerPage)->toArray();
            $ports = $ports['data'];
        } else {
            $ports = request()->site->ports;
            $count = $ports->count();
        }

        return response()->json([
            'data'     =>  $ports,
            'count'    =>   $count
        ], 200);
    }

    /*
     * To store a new value
     *
     *@
     */
    public function store(Request $request)
    {
        $request->validate([
            'port_name'        =>  'required',
        ]);

        $port = new Port(request()->all());
        $request->site->ports()->save($port);

        return response()->json([
            'data'    =>  $port
        ], 201);
    }

    /*
     * To view a single port
     *
     *@
     */
    public function show(Port $port)
    {
        return response()->json([
            'data'   =>  $port,
            'success' =>  true
        ], 200);
    }

    /*
     * To update a port
     *
     *@
     */
    public function update(Request $request, Port $port)
    {
        $port->update($request->all());

        return response()->json([
            'data'  =>  $port
        ], 200);
    }

    public function destroy($id)
    {
        $port = Port::find($id);
        $port->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
}
