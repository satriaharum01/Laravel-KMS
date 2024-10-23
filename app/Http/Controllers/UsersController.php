<?php

namespace App\Http\Controllers;

//Models
use App\Models\Departemen;
use App\Models\KMS;
use App\Models\Komentar;
use App\Models\Lampiran;
use App\Models\Log;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;


use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'level' => $request->level
        ];

        User::create($data);

        return redirect(route('admin.user'));
    }

    public function update(Request $request, $id)
    {
        $rows = User::find($id);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'level' => $request->level
        ];

        if($request->password)
        {
            $data['password'] = Hash::make($request->password);
        }

        $rows->update($data);

        return redirect(route('admin.user'));
    }

    public function destroy($id)
    {
        $rows = User::findOrFail($id);
        $rows->delete();

        return redirect(route('admin.user'));
    }

    public function json($id = 1)
    {
        $data = User::select('*')
            ->orderby('name', 'ASC')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = User::select('*')->where('id', $id)->get();

        return json_encode(array('data' => $data));
    }
}
