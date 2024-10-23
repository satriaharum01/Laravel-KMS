<?php

namespace App\Http\Livewire;

use App\Models\Acara;
use App\Models\Mesjid;
use App\Models\Ustad;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class Landing extends Component
{
    use WithPagination;

	public $searchTerm;
    public $currentPage = 1;
    public $title = 'Tester';

    private $bulan = array(
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    );
    public $data = array();

    private $hari = array(
        '1' => 'Senin',
        '2' => 'Selasa',
        '3' => 'Rabu',
        '4' => 'Kamis',
        '5' => "Jum'at",
        '6' => 'Sabtu',
        '7' => 'Minggu'
    );

    public function render()
    {
        $query = '%' . $this->searchTerm . '%';
        $data = Acara::where(function ($sub_query) {
            $sub_query->where('nama_acara', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('deskripsi', 'like', '%' . $this->searchTerm . '%');
        })->Paginate(5);

        foreach($data as $row) {
            $row->hari = $this->hari[date('N', strtotime($row->tanggal))];
            $row->mulai = date('h:i A', strtotime($row->mulai));
            $row->selesai = date('h:i A', strtotime($row->selesai));
            $row->title = strtolower(str_replace(' ', '-', $row->nama_acara));
            $array1 = explode("-", $row->tanggal);
            $tahun = $array1[0];
            $bulan1 = $array1[1];
            $hari = $array1[2];
            $bl1 = $this->bulan[$bulan1];
            $row->tanggal = $hari . ' ' . $bl1 . ' ' . $tahun;
        }
        $this->data['acara'] = $data;

        return view('livewire.index',$this->data);
    }


    public function setPage($url)
    {
        $this->currentPage = explode('page=', $url)[1];
        Paginator::currentPageResolver(function () {
            return $this->currentPage;
        });
    }
}
