<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Diskusi;
use App\Models\KMS;
use App\Models\Komentar;
use App\Models\Lampiran;
use App\Models\Log;
use App\Models\Notulen;
use App\Models\User;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;

//Models

class DiskusiController extends Controller
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
    public function baru()
    {
        $this->data['title'] = 'Tambah Diskusi';
        $this->data['link'] = url('/admin/diskusi/store');
        return view('admin.diskusi.detail', $this->data);
    }

    public function edit($id)
    {
        $this->data['title'] = 'Edit Diskusi';
        $this->data['link'] = url('/admin/diskusi/update/' . $id . '');
        $this->data['load'] = Diskusi::find($id);

        return view('admin.diskusi.detail', $this->data);

    }

    public function store(Request $request)
    {
        $data = [
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'author_id' => $request->author_id,
            'departemen_id' => $request->departemen_id,
            'tanggal' => $request->tanggal
        ];

        Diskusi::create($data);

        return redirect(route('admin.artikel'));
    }

    public function update(Request $request, $id)
    {
        $rows = Diskusi::find($id);
        $data = [
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'author_id' => $request->author_id,
            'departemen_id' => $request->departemen_id,
            'tanggal' => $request->tanggal
        ];

        $rows->update($data);

        return redirect(route('admin.diskusi'));
    }

    public function destroy($id)
    {
        $rows = Diskusi::findOrFail($id);
        $rows->delete();

        return redirect(route('admin.diskusi'));
    }

    public function json()
    {
        $data = Diskusi::select('*')
            ->orderby('created_at', 'DESC')
            ->get();
        foreach($data as $row) {
            $row->author = $row->cari_author->name;
            $row->time = date('h:', strtotime($row->tanggal)) . date('i', strtotime($row->tanggal));
            $row->tanggal = date('d ', strtotime($row->tanggal)) . $this->bulan[date('n', strtotime($row->tanggal))] .  date(' Y', strtotime($row->tanggal));
            $row->notulen = Notulen::select('*')->where('diskusi_id', $row->id)->count();
            $row->fill = $this->fill($row->author, $row->judul, $row->viewer, $row->notulen, $row->tanggal, $row->time);
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = Diskusi::select('*')->where('id', $id)->get();

        return json_encode(array('data' => $data));
    }

    public function fill($author, $judul, $viewer, $komentar, $tanggal, $time)
    {
        $content = array($author,$judul,$viewer, $komentar, $tanggal, $time);

        return $content;
    }
}
