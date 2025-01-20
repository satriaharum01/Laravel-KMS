<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\KMS;
use App\Models\Komentar;
use App\Models\Lampiran;
use App\Models\Log;
use App\Models\User;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

//Models

class HomeController extends Controller
{
    use WithPagination;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public $searchTerm;
    public $currentPage = 1;
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (isset(Auth::user()->id)) {
            return redirect(route('admin.dashboard'));
        } else {
            return redirect(route('login'));
        }
    }

    public function download($id)
    {
        $data = Lampiran::select('*')->where('artikel_id', $id)->first();
        if (empty($data)) {
            return '<script>"alert("Lampiran tidak ditemukan !");history.back();"</script>';
        }
        return redirect(url('assets/uploads/'.$data->file_path));
    }

    public function get_departemen($id = 1)
    {
        $data = Departemen::select('*')
            ->orderby('nama', 'ASC')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
