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
use Auth;
use Illuminate\Support\Facades\DB;

class LoginPegawai extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_pegawai');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->data['title'] = 'Dashboard';

        $this->data['c_artikel'] = $this->counter_artikel_pegawai();
        $this->data['c_diskusi'] = $this->counter_diskusi_pegawai();
        $this->data['c_komentar'] = $this->counter_komentar_pegawai();
        $this->data['c_viewer'] = $this->counter_viewer_pegawai();
        //GRAPH
        return view('pegawai.dashboard.index', $this->data);
    }

    //CONTENT
    public function artikel()
    {
        $this->data['title'] = 'Artikel';
        $this->page = '/pegawai/artikel';
        $this->view = 'pegawai/artikel/index';
        $this->data['page'] = $this->page;
        return view($this->view, $this->data);
    }

    public function my_artikel()
    {
        $this->data['title'] = 'Artikel Saya';
        $this->page = '/pegawai/artikel';
        $this->view = 'pegawai/artikel/data';
        $this->data['page'] = $this->page;
        return view($this->view, $this->data);
    }

    public function artikel_baca($id)
    {
        $load = KMS::find($id);
        $viewer = $load->viewer + 1;
        $load->update(['viewer' => $viewer]);
        $this->data['title'] = $load->judul;
        $this->data['side_title'] = 'Tulis Komentar';
        $this->page = '/pegawai/komentar';
        $this->view = 'pegawai/artikel/baca';
        $load = KMS::select('*')->where('id', $id)->get();

        foreach ($load as $row) {
            $row->author = $row->cari_author->name;
            $row->tanggal = date('d ', strtotime($row->created_at)) . $this->bulan[date('n', strtotime($row->created_at))] .  date(' Y', strtotime($row->created_at));
            $row->komentar = Komentar::select('*')->where('artikel_id', $row->id)->count();

            $komentar = Komentar::select('*')->where('artikel_id', $row->id)->get();
            $lampiran = Lampiran::select('*')->where('artikel_id', $row->id)->get();

            foreach ($komentar as $cek) {
                $cek->judul = $cek->cari_artikel->judul;
                $cek->user = $cek->cari_user->name;
                $cek->tanggal = date('d ', strtotime($cek->created_at)) . $this->bulan[date('n', strtotime($cek->created_at))] .  date(' Y', strtotime($cek->created_at));
            }
        }


        $this->data['post'] = $load;
        $this->data['artikel_id'] = $id;
        $this->data['lampiran'] = $lampiran;
        $this->data['komentar'] = $komentar;
        $this->data['page'] = $this->page;
        return view($this->view, $this->data);
    }

    public function artikel_baru()
    {
        $this->data['title'] = 'Tambah Artikel';
        $this->data['link'] = url('/pegawai/artikel/store');
        return view('pegawai.artikel.detail', $this->data);
    }

    public function artikel_edit($id)
    {
        $this->data['title'] = 'Edit Artikel';
        $this->data['link'] = url('/pegawai/artikel/update/' . $id . '');
        $this->data['load'] = KMS::find($id);

        return view('pegawai.artikel.detail', $this->data);

    }

    public function diskusi()
    {
        $this->data['title'] = 'Diskusi';
        $this->page = '/pegawai/diskusi';
        $this->view = 'pegawai/diskusi/index';
        $this->data['page'] = $this->page;
        return view($this->view, $this->data);
    }

    public function diskusi_baca($id)
    {
        $load = Diskusi::find($id);
        $this->data['title'] = $load->judul;
        $this->data['side_title'] = 'Tulis Notulen';
        $this->page = '/pegawai/notulen';
        $this->view = 'pegawai/diskusi/baca';
        $load = Diskusi::select('*')->where('id', $id)->get();

        foreach ($load as $row) {
            $row->author = $row->cari_author->name;
            $row->notulen = Notulen::select('*')->where('diskusi_id', $row->id)->count();

            $notulen = Notulen::select('*')->where('diskusi_id', $row->id)->get();

            foreach ($notulen as $cek) {
                $cek->judul = $cek->cari_diskusi->judul;
                $cek->user = $cek->cari_author->name;
                $cek->tanggal = date('d ', strtotime($cek->created_at)) . $this->bulan[date('n', strtotime($cek->created_at))] .  date(' Y', strtotime($cek->created_at));
            }
        }


        $this->data['post'] = $load;
        $this->data['diskusi_id'] = $id;
        $this->data['notulen'] = $notulen;
        $this->data['page'] = $this->page;
        return view($this->view, $this->data);
    }

    public function logs()
    {
        $this->data['title'] = 'Aktivitas';
        $this->page = '/pegawai/logs';
        $this->view = 'pegawai/logs/index';
        $this->data['page'] = $this->page;
        return view($this->view, $this->data);
    }

    //COUNTER
    public function counter_artikel_pegawai()
    {
        $data = KMS::select('*')->where('author_id', Auth::user()->id)->count();

        return $data;
    }
    public function counter_diskusi_pegawai()
    {
        $data = Diskusi::select('*')->where('author_id', Auth::user()->id)->count();

        return $data;
    }
    public function counter_komentar_pegawai()
    {
        $data = Komentar::select('*')->where('user_id', Auth::user()->id)->count();

        return $data;
    }
    public function counter_viewer_pegawai()
    {
        $data = KMS::select('*')->where('author_id', Auth::user()->id)->sum('viewer');

        return $data;
    }
}