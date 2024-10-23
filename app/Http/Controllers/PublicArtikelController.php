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

class PublicArtikelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->data['title'] = 'Artikel';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    //Page
    public function store(Request $request)
    {
        $data = [
            'judul' => $request->judul,
            'content' => $request->content,
            'author_id' => $request->author_id,
            'departemen_id' => $request->departemen_id,
            'viewer' => 0
        ];

        KMS::create($data);
        $file = $request->file('berkas');
        if (isset($file)) {
            $ext = '.' . $file->getClientOriginalExtension();
            $filename = $request->judul . $ext;
            $this->lampiran_destroy($filename);
            $file->storeAs('/', $filename, ['disk' => 'file_upload']);
        }
        $get = KMS::select('*')->where('judul', $request->judul)->where('author_id', $request->author_id)->first();
        $data = [
            'artikel_id' => $get->id,
            'file_path' => $filename
        ];

        Lampiran::create($data);
        $this->buat_notif('Menambah '.strtolower($this->data['title']), 'mdi-plus', 'primary');

        return redirect(route('pegawai.artikel.list'));
    }

    public function update(Request $request, $id)
    {
        $rows = KMS::find($id);
        $data = [
            'judul' => $request->judul,
            'content' => $request->content,
            'author_id' => $request->author_id,
            'departemen_id' => $request->departemen_id
        ];

        $rows->update($data);
        $this->buat_notif('Merubah '.strtolower($this->data['title']), 'mdi-pencil-box-outline', 'success');

        return redirect(route('pegawai.artikel.list'));
    }

    public function destroy($id)
    {
        $rows = KMS::findOrFail($id);
        $rows->delete();

        $this->buat_notif('Menghapus '.strtolower($this->data['title']), 'mdi-delete', 'danger');
        return redirect(route('pegawai.artikel.list'));
    }

    public function json()
    {
        $data = KMS::select('*')
            ->where('author_id', Auth::user()->id)
            ->orderby('created_at', 'DESC')
            ->get();
        foreach ($data as $row) {
            $row->author = 'Anda';
            $row->tanggal = date('d ', strtotime($row->created_at)) . $this->bulan[date('n', strtotime($row->created_at))] .  date(' Y', strtotime($row->created_at));
            $row->komentar = Komentar::select('*')->where('artikel_id', $row->id)->count();
            $row->fill = $this->fill($row->author, $row->judul, $row->viewer, $row->komentar, $row->tanggal);
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

    public function fill($author, $judul, $viewer, $komentar, $tanggal)
    {
        $content = array($author,$judul,$viewer, $komentar, $tanggal);

        return $content;
    }
}
