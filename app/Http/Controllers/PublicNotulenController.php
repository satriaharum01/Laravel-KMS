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

class PublicNotulenController extends Controller
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
            'diskusi_id' => $request->diskusi_id,
            'author_id' => Auth::user()->id,
            'catatan' => $request->catatan
        ];

        Notulen::create($data);
        $this->buat_notif('Menambah '.strtolower($this->data['title']), 'mdi-plus', 'primary');

        return redirect(url($request->url));
    }

    public function update(Request $request, $id)
    {
        $rows = Notulen::find($id);
        $data = [
            'catatan' => $request->content
        ];

        $rows->update($data);
        $this->buat_notif('Merubah '.strtolower($this->data['title']), 'mdi-pencil-box-outline', 'success');

        return redirect(url($request->url));
    }

    public function destroy(Request $request, $id)
    {
        $rows = Notulen::findOrFail($id);
        $rows->delete();

        $this->buat_notif('Menghapus '.strtolower($this->data['title']), 'mdi-delete', 'danger');
        return redirect(url($request->url));
    }

    public function json()
    {
        $data = Notulen::select('*')
            ->orderby('created_at', 'DESC')
            ->get();
        foreach ($data as $row) {
            $row->judul = $row->cari_diskusi->judul;
            $row->user = $row->cari_author->name;
            $row->tanggal = date('d ', strtotime($row->created_at)) . $this->bulan[date('n', strtotime($row->created_at))] .  date(' Y', strtotime($row->created_at));
            $row->fill = $this->fill($row->judul, $row->content, $row->tanggal);
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = Notulen::select('*')->where('id', $id)->get();

        foreach ($data as $row) {
            $row->diskusi = $row->cari_diskusi->judul;
            $row->user = $row->cari_author->name;
        }
        return json_encode(array('data' => $data));
    }

    public function fill($judul, $komentar, $tanggal)
    {
        $content = array($judul, $komentar, $tanggal);

        return $content;
    }
}
