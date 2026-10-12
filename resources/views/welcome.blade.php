<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Aplikasi Sertifikasi Sabrina</title>
        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Alpine.js untuk interaksi buka/tutup form register -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 text-slate-800 min-h-screen flex flex-col justify-between p-6 lg:p-8">
        
        <!-- Header -->
        <header class="w-full max-w-5xl mx-auto flex items-center justify-end">
            <nav class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-4 py-2 border border-slate-300 bg-white rounded-lg text-sm font-medium hover:bg-slate-50 transition shadow-sm">
                        Dashboard
                    </a>
                @else
                    
                @endauth
            </nav>
        </header>

        <!-- Konten Utama dengan Alpine.js (State untuk menampilkan Antarmuka Awal atau Form Register) -->
        <main class="w-full max-w-xl mx-auto my-auto py-8" x-data="{ showRegister: {{ $errors->any() ? 'true' : 'false' }} }">
            <div class="bg-white border border-slate-200/80 p-8 rounded-3xl shadow-xl backdrop-blur-sm">
                
                <h1 class="text-2xl lg:text-3xl font-extrabold mb-2 tracking-tight text-slate-900 text-center">
                      Selamat datang di Aplikasi Sertifikasi Sabrina
                </h1>

                @auth
                    <!-- Jika sudah login -->
                    <div class="text-center mt-4">
                        <p class="text-slate-600 mb-4">Anda sudah masuk ke dalam sistem.</p>
                        <a href="{{ route('dashboard') }}" class="inline-block w-full py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition shadow-md text-center">
                            Masuk ke Dashboard
                        </a>
                    </div>
                @else
                    <!-- TAMPILAN 1: Halaman Antarmuka Awal (Sebelum klik daftar) -->
                    <div x-show="!showRegister" class="text-center">
                        <p class="text-slate-600 text-sm mb-6">
                        Silakan masuk jika sudah punya akun, atau buat akun baru.
                        </p>
                        
                        <div class="space-y-3">
                            <a href="{{ route('login') }}" class="block w-full py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition shadow-md text-sm font-medium">
                                Masuk ke Halaman Login
                            </a>
                            <button @click="showRegister = true" class="block w-full py-3 bg-slate-100 text-slate-700 font-medium rounded-xl hover:bg-slate-200 transition shadow-sm text-sm">
                                Belum punya akun? Daftar di sini
                            </button>
                        </div>
                    </div>

                    <!-- TAMPILAN 2: Form Register (Muncul setelah tombol Daftar diklik) -->
                    <div x-show="showRegister" style="display: none;">
                        <p class="text-slate-600 text-sm mb-6 text-center">
                            Silakan isi data di bawah ini untuk mendaftarkan akun baru.
                        </p>

                        <!-- Pesan Error Validasi -->
                        @if ($errors->any())
                            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 text-sm rounded-xl">
                                <ul class="list-disc pl-4">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" required value="{{ old('name') }}" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                                <input type="email" name="email" required value="{{ old('email') }}" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                                <input type="password" name="password" required class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                            </div>
                            
                            <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition shadow-md text-sm">
                                Buat Akun & Masuk ke Dashboard
                            </button>
                        </form>

                        <div class="mt-4 text-center">
                            <button @click="showRegister = false" class="text-xs text-indigo-600 hover:underline">
                                &larr; Kembali ke halaman utama
                            </button>
                        </div>
                    </div>
                @endauth

            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full max-w-5xl mx-auto text-center text-xs text-slate-500">
           
    </footer>

    </body>
</html>