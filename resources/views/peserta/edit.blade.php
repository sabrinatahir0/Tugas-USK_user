@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Ubah Data Peserta</h3>

    <form action="{{ route('peserta.update', $peserta->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Peserta</label>
            <input type="text" name="nama" class="form-control" value="{{ $peserta->nama }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $peserta->email }}" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" class="form-control" value="{{ $peserta->no_hp }}" required>
        </div>

        <div class="mb-3">
            <label>Pilih Skema</label>
            <select name="skema_id" class="form-select" required>
                @foreach($skema as $s)
                    <option value="{{ $s->id }}" {{ $peserta->skema_id == $s->id ? 'selected' : '' }}>
                        {{ $s->nama_skema }} ({{ $s->kode_skema }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('peserta.index') }}" class="btn btn-light btn-outline-danger">Batal</a>
    </form>
</div>
@endsection