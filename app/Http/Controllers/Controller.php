<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Diskusi;
use App\Models\KMS;
use App\Models\Komentar;
use App\Models\Lampiran;
use App\Models\Log;
use App\Models\User;
use File;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public $bulan = array('','Januari','Febuari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');

    public function buat_notif($title, $icon, $color)
    {
        $data = [
            'action' => $title,
            'status' => 'wait',
            'icon' => $icon,
            'color' => $color,
            'user_id' => Auth::user()->id
        ];

        Log::create($data);
    }

    public function clear_lampiran($artikel_id)
    {
        Lampiran::where('artikel_id', $artikel_id)->delete();
    }

    public function lampiran_destroy($filename)
    {
        if (File::exists(public_path('/assets/uploads/' . $filename . ''))) {
            File::delete(public_path('/assets/uploads' . $filename . ''));
        }
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
