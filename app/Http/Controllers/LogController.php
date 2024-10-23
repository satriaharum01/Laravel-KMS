<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\KMS;
use App\Models\Komentar;
use App\Models\Lampiran;
use App\Models\Log;
use App\Models\User;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;

//Models

class LogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $data = [
            'nama' => $request->nama
        ];

        Departemen::create($data);

        return redirect(route('admin.departemen'));
    }

    public function update(Request $request, $id)
    {
        $rows = Departemen::find($id);
        $data = [
            'nama' => $request->nama
        ];


        $rows->update($data);

        return redirect(route('admin.departemen'));
    }

    public function destroy($id)
    {
        $rows = Departemen::findOrFail($id);
        $rows->delete();

        return redirect(route('admin.departemen'));
    }

    public function json($id = 1)
    {
        $data = Departemen::select('*')
            ->orderby('nama', 'ASC')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = Departemen::select('*')->where('id', $id)->get();

        return json_encode(array('data' => $data));
    }
}
