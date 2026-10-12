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
            'nama'     => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email'    => 'required|email|unique:peserta,email',
            'no_hp'    => 'required|string|max:20',
            'skema_id' => 'required|exists:skema,id',
        ], [
            'nama.required'     => 'Nama peserta wajib diisi.',
            'nama.regex'        => 'Nama peserta hanya boleh berisi huruf dan spasi (tidak boleh mengandung angka atau simbol).',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email ini sudah terdaftar.',
            'no_hp.required'    => 'Nomor HP wajib diisi.',
            'no_hp.max'         => 'Nomor HP tidak boleh lebih dari 20 karakter.',
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
    
    // Jika bukan admin dan mencoba mengedit data orang lain, tolak!
    if (auth()->user()->role !== 'admin' && $peserta->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    $skema = Skema::all();
    return view('peserta.edit', compact('peserta', 'skema'));
}

public function update(Request $request, $id)
    {
    $peserta = Peserta::findOrFail($id);

    // Validasi kepemilikan data
    if (auth()->user()->role !== 'admin' && $peserta->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    $request->validate([
        'nama'     => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
        'email'    => 'required|email|unique:peserta,email,'.$id,
        'no_hp'    => 'required|string|max:20',
        'skema_id' => 'required|exists:skema,id',
    ], [
        'nama.regex' => 'Nama peserta hanya boleh berisi huruf dan spasi.',
        'no_hp.max'  => 'Nomor HP maksimal 20 karakter.',
    ]);

    $peserta->update($request->all());

    return redirect()->route('peserta.index')->with('success', 'Data diri berhasil diperbarui!');
    }

    public function destroy($id) 
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->delete();

        return redirect()->route('peserta.index')->with('success', 'Data peserta berhasil dihapus!');
    }
}