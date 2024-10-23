<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\KMS;
use App\Models\Komentar;
use App\Models\Lampiran;
use App\Models\Log;
use App\Models\User;
use File;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;

//Models

class PublicLogsController extends Controller
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
    //Page

    public function json()
    {
        $data = Logs::select('*')
            ->where('user_id', Auth::user()->id)
            ->orderby('created_at', 'DESC')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = KMS::select('*')->where('id', $id)->get();

        return json_encode(array('data' => $data));
    }

    public function fill($author, $judul, $viewer, $komentar, $tanggal)
    {
        $content = array($author,$judul,$viewer, $komentar, $tanggal);

        return $content;
    }
}
