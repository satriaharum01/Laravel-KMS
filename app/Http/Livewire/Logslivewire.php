<?php

namespace App\Http\Livewire;

use App\Models\Departemen;
use App\Models\Diskusi;
use App\Models\KMS;
use App\Models\Komentar;
use App\Models\Lampiran;
use App\Models\Log;
use App\Models\Notulen;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use Illuminate\Support\Facades\DB;

class Logslivewire extends Component
{
    use WithPagination;

    public $data;
    public $searchTerm;
    public $currentPage = 1;
    public $title = 'Aktivitas';
    public $bulan = array('','Januari','Febuari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');

    public function render()
    {
        $query = '%' . $this->searchTerm . '%';
        $load = Log::where(function ($sub_query) {
            $sub_query->where('action', 'like', '%' . $this->searchTerm . '%');
        })->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->Paginate(10);

        foreach ($load as $row) {
            $row->author = $row->cari_user->name;
            $row->time = date('h:', strtotime($row->created_at)) . date('i', strtotime($row->created_at));
            $row->tanggal = date('d ', strtotime($row->created_at)) . $this->bulan[date('n', strtotime($row->created_at))] .  date(' Y', strtotime($row->created_at));
        }

        $departemen = Departemen::select('*')->get();
        $this->data['departemen'] = $departemen;
        $this->data['post'] = $load;
        $this->data['c_artikel'] = $this->counter_post();
        $this->data['c_diskusi'] = $this->counter_diskusi();
        $this->data['c_user'] = $this->counter_user();
        $this->data['c_departemen'] = $this->counter_departemen();
        $this->data['side_title'] = '-';
        return view('livewire.logs', $this->data);
    }


    public function setPage($url)
    {
        $this->currentPage = explode('page=', $url)[1];
        Paginator::currentPageResolver(function () {
            return $this->currentPage;
        });
    }

    public function counter_user()
    {
        $data = User::select('*')->count();

        return $data;
    }

    public function counter_post()
    {
        $data = KMS::select('*')->count();

        return $data;
    }

    public function counter_departemen()
    {
        $data = Departemen::select('*')->count();

        return $data;
    }

    public function counter_diskusi()
    {
        $data = Diskusi::select('*')->count();

        return $data;
    }
}
