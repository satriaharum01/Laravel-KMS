<?php

namespace App\Http\Livewire;

use App\Models\Departemen;
use App\Models\Diskusi;
use App\Models\KMS;
use App\Models\Komentar;
use App\Models\Lampiran;
use App\Models\Notulen;
use App\Models\Log;
use App\Models\User;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class Artikel extends Component
{
    use WithPagination;

    public $data;
    public $selectcat;
    public $searchTerm;
    public $currentPage = 1;
    public $title = 'Artikel';
    public $bulan = array('','Januari','Febuari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');

    public function render()
    {
        $query = '%' . $this->searchTerm . '%';
        $load = KMS::where(function ($sub_query) {
            if($this->selectcat != '') {
                $sub_query->where('departemen_id', $this->selectcat)->where('judul', 'like', '%' . $this->searchTerm . '%');
            } else {
                $sub_query->where('judul', 'like', '%' . $this->searchTerm . '%');
            }
        })->orderBy('created_at', 'DESC')->Paginate(10);

        foreach($load as $row) {
            $row->author = $row->cari_author->name;
            $row->tanggal = date('d ', strtotime($row->created_at)) . $this->bulan[date('n', strtotime($row->created_at))] .  date(' Y', strtotime($row->created_at));
            $row->komentar = Komentar::select('*')->where('artikel_id', $row->id)->count();
        }

        $departemen = Departemen::select('*')->get();
        $this->data['departemen'] = $departemen;
        $this->data['post'] = $load;
        $this->data['c_artikel'] = $this->counter_post();
        $this->data['c_diskusi'] = $this->counter_diskusi();
        $this->data['c_user'] = $this->counter_user();
        $this->data['c_departemen'] = $this->counter_departemen();
        $this->data['side_title'] = 'Buat Artikel';
        return view('livewire.artikel', $this->data);
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
