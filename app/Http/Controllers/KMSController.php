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

class KMSController extends Controller
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
        $this->data['title'] = 'Tambah Artikel';
        $this->data['link'] = url('/admin/artikel/store');
        return view('admin.artikel.detail', $this->data);
    }

    public function edit($id)
    {
        $this->data['title'] = 'Edit Artikel';
        $this->data['link'] = url('/admin/artikel/update/' . $id . '');
        $this->data['load'] = KMS::find($id);

        return view('admin.artikel.detail', $this->data);

    }

    public function store(Request $request)
    {
        $data = [
            'judul' => $request->judul,
            'content' => $request->content,
            'author_id' => $request->author_id,
            'departemen_id' => $request->departemen_id,
            'viewer' => 0,
            'status' => $request->status
        ];

        KMS::create($data);
        $file = $request->file('berkas');
        if (isset($file)) {
            $ext = '.' . $file->getClientOriginalExtension();
            $filename = $request->judul . $ext;
            $this->lampiran_destroy($filename);
            $file->storeAs('/', $filename, ['disk' => 'file_upload']);

            $get = KMS::select('*')->where('judul', $request->judul)->where('author_id', $request->author_id)->first();
            $data = [
                'artikel_id' => $get->id,
                'file_path' => $filename
            ];
            $this->clear_lampiran($get->id);
            Lampiran::create($data);
        }


        return redirect(route('admin.artikel'));
    }

    public function update(Request $request, $id)
    {
        $rows = KMS::find($id);
        $data = [
            'judul' => $request->judul,
            'content' => $request->content,
            'author_id' => $request->author_id,
            'departemen_id' => $request->departemen_id,
            'status' => $request->status
        ];

        $rows->update($data);

        $file = $request->file('berkas');
        if (isset($file)) {
            $ext = '.' . $file->getClientOriginalExtension();
            $filename = $request->judul . $ext;
            $this->lampiran_destroy($filename);
            $file->storeAs('/', $filename, ['disk' => 'file_upload']);

            $get = KMS::select('*')->where('judul', $request->judul)->where('author_id', $request->author_id)->first();
            $data = [
                'artikel_id' => $get->id,
                'file_path' => $filename
            ];
            $this->clear_lampiran($get->id);
            Lampiran::create($data);

        }

        return redirect(route('admin.artikel'));
    }

    public function destroy($id)
    {
        $rows = KMS::findOrFail($id);
        $rows->delete();

        return redirect(route('admin.artikel'));
    }

    public function json()
    {
        $data = KMS::select('*')
            ->orderby('created_at', 'DESC')
            ->get();
        foreach ($data as $row) {
            $row->author = $row->cari_author->name;
            $row->tanggal = date('d ', strtotime($row->created_at)) . $this->bulan[date('n', strtotime($row->created_at))] .  date(' Y', strtotime($row->created_at));
            $row->komentar = Komentar::select('*')->where('artikel_id', $row->id)->count();
            $row->fill = $this->fill($row->author, $row->judul, $row->viewer, $row->komentar, $row->tanggal, $row->status);
            $lampiran = Lampiran::select('*')->where('artikel_id', $row->id)->get();
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = KMS::select('*')->where('id', $id)->get();

        return json_encode(array('data' => $data));
    }

    public function fill($author, $judul, $viewer, $komentar, $tanggal, $status)
    {
        $color = array(
            'Accepted' => 'success',
            'Waiting' => 'info',
            'Declined' => 'danger'
        );
        $content = array($author,$judul,$viewer, $komentar, $tanggal,$status,$color[$status]);

        return $content;
    }
}
