<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta; 
use App\Models\Skema;

class DashboardController extends Controller
{
    public function index() {
        $total_peserta = Peserta::count();
        $total_skema = Skema::count();

        $peserta_terbaru = Peserta::with('skema')->latest()->take(5)->get();

     
        return view('dashboard', compact('total_peserta', 'total_skema', 'peserta_terbaru'));
    }
}