<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JWD Sertifikasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light shadow-sm mb-4" style="background-color: #e67db7;">
    <div class="container">
        <a class="navbar-brand fw-bold text-dark" href="{{ route('dashboard') }}">JWD App Sabrina</a>
        
        <div class="navbar-nav ms-auto align-items-center">
            @foreach (['dashboard' => 'Dashboard', 'skema.index' => 'Data Skema', 'peserta.index' => 'Data Peserta'] as $route => $label)
                <a class="nav-link text-dark fw-semibold" href="{{ route($route) }}">{{ $label }}</a>
            @endforeach

            <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container pb-5">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>