@extends('layouts.app')

@section('content')
<h3>Kelola Data Skema</h3>
<hr>
<div class="card p-3 mb-4">
    <h5>Tambah Skema</h5>
    <form method="POST" action="{{ route('skema.store') }}" class="row g-2">
        @csrf
        <div class="col-md-4">
            <input type="text" name="kode_skema" class="form-control" placeholder="Kode Skema" required>
        </div>
        <div class="col-md-6">
            <input type="text" name="nama_skema" class="form-control" placeholder="Nama Skema" required>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success w-100">Simpan</button>
        </div>
    </form>
</div>

<table class="table table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Skema</th>
            <th width="150">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($skema as $key => $s)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $s->kode_skema }}</td>
            <td>{{ $s->nama_skema }}</td>
            <td class="d-flex gap-1">
                {{-- Tombol Edit --}}
                <a href="{{ route('skema.edit', $s->id) }}" class="btn btn-warning btn-sm text-black">Edit</a>

                {{-- Form Hapus --}}
                <form action="{{ route('skema.destroy', $s->id) }}" method="POST">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm text-black" onclick="return confirm('Hapus skema?')">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">Belum ada data skema.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection