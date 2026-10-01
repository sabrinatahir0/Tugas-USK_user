<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Skema;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->get('cari');

        $peserta = Peserta::with('skema')
            ->when($cari, function($q) use ($cari) {
                $q->where('nama', 'like', "%{$cari}%")
                  ->orWhereHas('skema', function($sq) use ($cari) {
                      $sq->where('nama_skema', 'like', "%{$cari}%");
                  });
            })
            ->latest()
            ->get();

        return view('skema.peserta.index', compact('peserta', 'cari'));
    }

    public function create()
    {
        $skema = Skema::all(); // Mengambil semua skema untuk dropdown select
        return view('skema.peserta.create', compact('skema'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required',
            'email'    => 'required|email',
            'no_hp'    => 'required',
            'skema_id' => 'required|exists:skema,id',
        ]);

        Peserta::create($request->all());

        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil ditambahkan!');
    }

    public function show($id)
    {
        $peserta = Peserta::with('skema')->findOrFail($id);
        return view('skema.peserta.show', compact('peserta'));
    }

    public function edit($id)
    {
        $peserta = Peserta::findOrFail($id);
        $skema = Skema::all();
        
        return view('skema.peserta.edit', compact('peserta', 'skema'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'     => 'required',
            'email'    => 'required|email',
            'no_hp'    => 'required',
            'skema_id' => 'required|exists:skema,id',
        ]);

        $peserta = Peserta::findOrFail($id);
        $peserta->update($request->all());

        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Peserta::destroy($id);
        return redirect()->route('peserta.index')->with('success', 'Peserta berhasil dihapus!');
    }
}