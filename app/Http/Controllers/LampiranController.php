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
use File;

//Models

class LampiranController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $file = $request->file('berkas');
        if (isset($file)) {
            $ext = '.' . $file->getClientOriginalExtension();
            $filename = $request->nama . $ext;
            $this->lampiran_destroy($filename);
            $file->storeAs('/', $filename, ['disk' => 'file_upload']);

            $data = [
                'artikel_id' => $request->artikel_id,
                'file_path' => $filename
            ];

            Lampiran::create($data);
        }

        return redirect(route('admin.lampiran'));
    }

    public function update(Request $request, $id)
    {
        $file = $request->file('berkas');
        if (isset($file)) {
            $ext = '.' . $file->getClientOriginalExtension();

            $rows = Lampiran::find($id);
            $filename = $rows->cari_artikel->judul . $ext;
            $this->lampiran_destroy($filename);

            $file->storeAs('/', $filename, ['disk' => 'file_upload']);
            $data = [
                'file_path' => $filename
            ];

            $rows->update($data);
        }

        return redirect(route('admin.lampiran'));
    }

    public function destroy($id)
    {
        $rows = Lampiran::findOrFail($id);
        $rows->delete();

        return redirect(route('admin.lampiran'));
    }

    public function json()
    {
        $data = Lampiran::select('*')
            ->orderby('created_at', 'DESC')
            ->get();
        foreach ($data as $row) {
            $row->judul = $row->cari_artikel->judul;
            $row->author = $row->cari_artikel->cari_author->name;
            $row->tanggal = date('d ', strtotime($row->created_at)) . $this->bulan[date('n', strtotime($row->created_at))] .  date(' Y', strtotime($row->created_at));
            $row->fill = $this->fill($row->judul, $row->author, $row->tanggal);
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = Lampiran::select('*')->where('id', $id)->get();

        foreach ($data as $row) {
            $row->artikel = $row->cari_artikel->judul;
            $row->author = $row->cari_artikel->cari_author->name;
        }
        return json_encode(array('data' => $data));
    }

    public function download($id)
    {
        $data = Lampiran::find($id);

        return redirect(url('assets/uploads/'.$data->file_path));
    }

    public function fill($judul, $author, $tanggal)
    {
        $content = array($judul, $author, $tanggal);

        return $content;
    }
}
