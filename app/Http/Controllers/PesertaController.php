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

        return view('peserta.index', compact('peserta', 'cari'));
    }

    public function create()
    {
        $skema = Skema::all();
        return view('peserta.create', compact('skema'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:peserta,email',
            'no_hp'    => 'required',
            'skema_id' => 'required|exists:skema,id',
        ], [
            'nama.required'     => 'Nama peserta wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email ini sudah terdaftar.',
            'no_hp.required'    => 'Nomor HP wajib diisi.',
            'skema_id.required' => 'Pilih skema sertifikasi.',
        ]);

        Peserta::create($request->all());

        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil ditambahkan!');
    }

    public function show($id)
    {
        $peserta = Peserta::with('skema')->findOrFail($id);
        return view('peserta.show', compact('peserta'));
    }

    public function edit($id)
    {
        $peserta = Peserta::findOrFail($id);
        $skema = Skema::all();
        
        return view('peserta.edit', compact('peserta', 'skema'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:peserta,email,'.$id,
            'no_hp'    => 'required',
            'skema_id' => 'required|exists:skema,id',
        ], [
            'nama.required'     => 'Nama peserta wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email ini sudah terdaftar.',
            'no_hp.required'    => 'Nomor HP wajib diisi.',
            'skema_id.required' => 'Pilih skema sertifikasi.',
        ]);

        $peserta = Peserta::findOrFail($id);
        $peserta->update($request->all());

        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil diperbarui!');
    }

    public function destroy($id) 
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->delete();

        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil dihapus!');
    }
}