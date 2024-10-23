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
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
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
    public function index()
    {
        $this->data['title'] = 'Dashboard';

        //MONITOR
        $this->data['c_departemen'] = $this->c_departemen();
        $this->data['c_users'] = $this->c_users();
        $this->data['c_post'] = $this->c_post();
        $this->data['c_berkas'] = $this->c_berkas();
        //GRAPH
        return view('admin.dashboard.index', $this->data);
    }

    //CONTENT
    public function departemen()
    {
        $this->data['title'] = 'Data Departemen';
        $this->page = '/admin/departemen';
        $this->view = 'admin/departemen/index';
        $this->data['page'] = $this->page;
        return view($this->view, $this->data);
    }

    public function artikel()
    {
        $this->data['title'] = 'Data Artikel';
        $this->page = '/admin/artikel';
        $this->view = 'admin/artikel/index';
        $this->data['page'] = $this->page;
        return view($this->view, $this->data);
    }

    public function komentar()
    {
        $this->data['title'] = 'Daftar komentar';
        $this->page = '/admin/komentar';
        $this->view = 'admin/komentar/index';
        $this->data['page'] = $this->page;
        return view($this->view, $this->data);
    }

    public function lampiran()
    {
        $this->data['title'] = 'Daftar lampiran';
        $this->page = '/admin/lampiran';
        $this->view = 'admin/lampiran/index';
        $this->data['page'] = $this->page;
        return view($this->view, $this->data);
    }

    public function diskusi()
    {
        $this->data['title'] = 'Data Diskusi';
        $this->page = '/admin/diskusi';
        $this->view = 'admin/diskusi/index';
        $this->data['page'] = $this->page;
        return view($this->view, $this->data);
    }

    public function user()
    {
        $this->data['title'] = 'Data Pengguna';
        $this->page = '/admin/user';
        $this->view = 'admin/user/index';
        $this->data['page'] = $this->page;
        return view($this->view, $this->data);
    }
    //COUNTER
    public function c_departemen()
    {
        $data = Departemen::select('*')->count();

        return $data;
    }

    public function c_users()
    {
        $data = User::select('*')->count();

        return $data;
    }

    public function c_post()
    {
        $data = KMS::select('*')->count();

        return $data;
    }

    public function c_berkas()
    {
        $data = Lampiran::select('*')->count();

        return $data;
    }
}
