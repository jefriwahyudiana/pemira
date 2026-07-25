<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paslon;

class HasilHimaController extends Controller
{
    public function index()
    {
        $paslons = Paslon::where('jenis_pemilihan', '!=', 'presma')
            ->orderBy('total_vote', 'desc')
            ->get();
        $himas = $paslons->groupBy('jenis_pemilihan');
        return view('hasil_hima', compact('himas'));
    }
}
