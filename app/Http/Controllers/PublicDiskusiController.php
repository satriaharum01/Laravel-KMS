<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\KMS;
use App\Models\Diskusi;
use App\Models\Komentar;
use App\Models\Response;
use App\Models\Log;
use App\Models\User;
use File;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Auth;

//Models

class PublicDiskusiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->data['title'] = 'Diskusi';
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
            'status' => $request->status,
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'author_id' => $request->author_id,
            'departemen_id' => $request->departemen_id,
            'tanggal' => $request->tanggal
        ];

        Diskusi::create($data);
        $this->buat_notif('Menambah '.strtolower($this->data['title']), 'mdi-plus', 'primary');

        return redirect(route('pegawai.diskusi.list'));
    }

    public function update(Request $request, $id)
    {
        $rows = Diskusi::find($id);
        $data = [
            'status' => $request->status,
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'author_id' => $request->author_id,
            'departemen_id' => $request->departemen_id,
            'tanggal' => $request->tanggal
        ];

        $rows->update($data);
        $this->buat_notif('Merubah '.strtolower($this->data['title']), 'mdi-pencil-box-outline', 'success');

        return redirect(route('pegawai.diskusi.list'));
    }

    public function destroy($id)
    {
        $rows = Diskusi::findOrFail($id);
        $rows->delete();

        $this->buat_notif('Menghapus '.strtolower($this->data['title']), 'mdi-delete', 'danger');
        return redirect(route('pegawai.diskusi.list'));
    }

    public function json()
    {
        $data = Diskusi::select('*')
            ->where('author_id', Auth::user()->id)
            ->orderby('created_at', 'DESC')
            ->get();
        foreach ($data as $row) {
            $row->author = 'Anda';
            $row->tanggal = date('d ', strtotime($row->created_at)) . $this->bulan[date('n', strtotime($row->created_at))] .  date(' Y', strtotime($row->created_at));
            $row->komentar = Response::select('*')->where('diskusi_id', $row->id)->count();
            $row->fill = $this->fill($row->author, $row->judul, $row->komentar, $row->tanggal);
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

    public function fill($author, $judul, $komentar, $tanggal)
    {
        $content = array($author,$judul, $komentar, $tanggal);

        return $content;
    }
}
