<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Informasi Resmi Layanan Publik {{ $service->nama_layanan }} — Portal Pelayanan Terpadu Pemerintah Kabupaten Tasikmalaya">
    <title>{{ $service->nama_layanan }} — Portal Layanan Publik Kab. Tasikmalaya</title>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        body { letter-spacing: -0.01em; }
        [data-lucide] { display: inline-block; vertical-align: middle; }
    </style>
</head>
<body class="min-h-full flex flex-col bg-[#f8fafc] text-slate-800 antialiased selection:bg-[#0a2558] selection:text-white">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. NAVBAR SEDERHANA & BERSIH
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-2xs">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between gap-4">
            
            {{-- Tombol Kembali & Logo --}}
            <div class="flex items-center gap-3">
                <a href="{{ url('/#layanan') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 hover:text-blue-700 hover:bg-blue-50 transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Semua Layanan</span>
                </a>
                <span class="text-slate-300 hidden sm:inline">|</span>
                <a href="{{ url('/') }}" class="hidden sm:flex items-center gap-2">
                    <img src="{{ asset('images/logo2.png') }}" alt="Diskominfo Kab. Tasikmalaya" class="h-8 w-auto object-contain">
                </a>
            </div>

            {{-- Status Akun / Masuk --}}
            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold text-white bg-[#0a2558] hover:bg-[#0d3070] transition-colors flex items-center gap-1.5 shadow-xs">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        <span>Dashboard Saya</span>
                    </a>
                @else
                    <a href="{{ route('login', ['service' => $service->kode_layanan]) }}"
                       class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold text-[#0a2558] hover:bg-slate-100 transition-colors flex items-center gap-1.5">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        <span>Masuk Portal</span>
                    </a>
                @endauth
            </div>

        </div>
    </header>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. KONTEN UTAMA (LAYOUT TUNGGAL / TERFOKUS)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <main class="max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-10 flex-1 w-full space-y-7">

        {{-- ── KARTU UTAMA: JUDUL LAYANAN & RINGKASAN BIAYA ── --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-6">
            
            {{-- Breadcrumb & Badge --}}
            <div class="flex items-center justify-between gap-2 flex-wrap">
                <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                    <a href="{{ url('/') }}" class="hover:text-blue-700">Beranda</a>
                    <span>/</span>
                    <a href="{{ url('/#layanan') }}" class="hover:text-blue-700">Layanan Publik</a>
                    <span>/</span>
                    <span class="text-slate-700 font-semibold">{{ $service->kode_layanan }}</span>
                </div>

                @if ($service->isFullDigital())
                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                        <span>Pelayanan Full Online</span>
                    </span>
                @else
                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200 flex items-center gap-1">
                        <i data-lucide="building" class="w-3.5 h-3.5"></i>
                        <span>Pelayanan Hybrid</span>
                    </span>
                @endif
            </div>

            {{-- Judul & Deskripsi Singkat --}}
            <div class="space-y-2">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
                    {{ $service->nama_layanan }}
                </h1>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-normal">
                    {{ $service->deskripsi }}
                </p>
            </div>

            {{-- 3 Info Penting (Biaya, Waktu, Berkas) --}}
            <div class="grid grid-cols-3 gap-2 sm:gap-4 pt-2">
                {{-- Biaya --}}
                <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-3 sm:p-4 text-center">
                    <p class="text-[11px] text-slate-500 font-semibold">Biaya Layanan</p>
                    <p class="text-xs sm:text-sm font-extrabold text-emerald-700 mt-0.5">Rp 0 (GRATIS)</p>
                </div>
                {{-- Waktu --}}
                <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-3 sm:p-4 text-center">
                    <p class="text-[11px] text-slate-500 font-semibold">Estimasi Selesai</p>
                    <p class="text-xs sm:text-sm font-bold text-slate-800 mt-0.5">1 - 3 Hari Kerja</p>
                </div>
                {{-- Jumlah Berkas --}}
                <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-3 sm:p-4 text-center">
                    <p class="text-[11px] text-slate-500 font-semibold">Persyaratan</p>
                    <p class="text-xs sm:text-sm font-bold text-slate-800 mt-0.5">{{ $service->requirements->count() }} Dokumen</p>
                </div>
            </div>

            {{-- Tombol CTA Utama (Atas) --}}
            <div class="pt-2">
                <a href="{{ route('warga.submissions.create', ['service' => $service->kode_layanan]) }}"
                   id="btnAjukanLayananTop"
                   class="w-full py-3.5 px-6 rounded-xl font-extrabold text-sm sm:text-base text-white bg-[#0a2558] hover:bg-[#0d3070] transition-colors shadow-sm flex items-center justify-center gap-2 group text-center cursor-pointer">
                    <span>AJUKAN LAYANAN SEKARANG</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </a>

                @guest
                    <p class="text-[11px] text-slate-500 text-center mt-2.5">
                        <i data-lucide="info" class="w-3.5 h-3.5 inline mr-1 text-slate-400"></i>
                        Jika belum masuk, Anda akan diminta login atau daftar akun terlebih dahulu.
                    </p>
                @endguest
            </div>

        </div>


        {{-- ── BAGIAN 1: DOKUMEN PERSYARATAN PENGAJUAN (CHECKLIST MUDAH) ── --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="clipboard-check" class="w-5 h-5 text-blue-600"></i>
                    <span>Dokumen Persyaratan Pengajuan</span>
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    Siapkan foto atau scan dokumen berikut sebelum mengisi formulir:
                </p>
            </div>

            {{-- List Persyaratan --}}
            <div class="space-y-3 pt-1">
                @forelse ($service->requirements as $index => $req)
                    <div class="p-3.5 sm:p-4 rounded-xl border border-slate-200/80 bg-slate-50/50 flex items-start gap-3.5">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="text-sm font-bold text-slate-900">
                                    {{ $req->nama_persyaratan }}
                                </h3>
                                @if ($req->is_required)
                                    <span class="px-2 py-0.2 rounded text-[10px] font-bold uppercase bg-rose-50 text-rose-700 border border-rose-200">
                                        Wajib
                                    </span>
                                @else
                                    <span class="px-2 py-0.2 rounded text-[10px] font-bold uppercase bg-slate-200/70 text-slate-600">
                                        Opsional
                                    </span>
                                @endif
                            </div>

                            @if ($req->deskripsi)
                                <p class="text-xs text-slate-600 mt-1 leading-relaxed">
                                    {{ $req->deskripsi }}
                                </p>
                            @endif

                            <p class="text-[11px] text-slate-400 mt-1">
                                Format: <span class="uppercase font-semibold text-slate-600">{{ implode(', ', $req->accepted_formats ?? ['PDF', 'JPG']) }}</span> &bull; Maks. {{ round($req->max_size_kb / 1024, 1) }} MB
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-xs text-slate-500">
                        Tidak ada dokumen khusus yang dibutuhkan.
                    </div>
                @endforelse
            </div>

            {{-- Formulir Fisik jika Ada --}}
            @if ($service->isHybrid() && $service->template_formulir_path)
                <div class="mt-4 p-4 rounded-xl bg-amber-50/70 border border-amber-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <div class="text-xs text-amber-900">
                        <p class="font-bold">Membutuhkan Formulir Fisik / Pengantar</p>
                        <p class="text-amber-800 mt-0.5">Unduh template, lengkapi tanda tangan di kantor desa, lalu foto/scan untuk diunggah.</p>
                    </div>
                    <a href="#"
                       onclick="alert('Template formulir resmi siap diunduh.'); return false;"
                       class="px-3 py-1.5 rounded-lg text-xs font-bold bg-amber-600 hover:bg-amber-700 text-white shrink-0 shadow-xs inline-flex items-center gap-1.5 transition-colors">
                        <i data-lucide="download" class="w-3.5 h-3.5"></i>
                        <span>Unduh Formulir</span>
                    </a>
                </div>
            @endif
        </div>


        {{-- ── BAGIAN 2: ALUR PENGAJUAN (4 LANGKAH SEDERHANA) ── --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="route" class="w-5 h-5 text-blue-600"></i>
                    <span>Cara Pengajuan (4 Langkah Mudah)</span>
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    Proses pengajuan dari awal hingga dokumen selesai.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-1">
                {{-- Langkah 1 --}}
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70 flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full bg-[#0a2558] text-white text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">1</span>
                    <div class="text-xs">
                        <p class="font-bold text-slate-900 text-sm">Isi Formulir</p>
                        <p class="text-slate-600 mt-1 leading-relaxed">Klik tombol ajukan layanan, lalu lengkapi biodata dan data permohonan.</p>
                    </div>
                </div>

                {{-- Langkah 2 --}}
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70 flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full bg-[#0a2558] text-white text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">2</span>
                    <div class="text-xs">
                        <p class="font-bold text-slate-900 text-sm">Unggah Berkas</p>
                        <p class="text-slate-600 mt-1 leading-relaxed">Upload foto atau scan dokumen persyaratan yang diminta secara jelas.</p>
                    </div>
                </div>

                {{-- Langkah 3 --}}
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70 flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full bg-[#0a2558] text-white text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">3</span>
                    <div class="text-xs">
                        <p class="font-bold text-slate-900 text-sm">Verifikasi Petugas</p>
                        <p class="text-slate-600 mt-1 leading-relaxed">Petugas memeriksa berkas. Anda dapat memantau status secara langsung.</p>
                    </div>
                </div>

                {{-- Langkah 4 --}}
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70 flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">4</span>
                    <div class="text-xs">
                        <p class="font-bold text-slate-900 text-sm">Dokumen Terbit</p>
                        <p class="text-slate-600 mt-1 leading-relaxed">Dokumen resmi dapat diunduh langsung atau diambil di kantor kecamatan.</p>
                    </div>
                </div>
            </div>
        </div>


        {{-- ── TOMBOL CTA UTAMA (BAWAH) ── --}}
        <div class="bg-blue-50/70 border border-blue-200/80 rounded-2xl p-6 sm:p-7 text-center space-y-3">
            <h3 class="text-base sm:text-lg font-extrabold text-slate-900">
                Sudah Menyiapkan Seluruh Persyaratan?
            </h3>
            <p class="text-xs text-slate-600 max-w-md mx-auto">
                Silakan mulai buat permohonan sekarang. Proses cepat dan bebas pungutan biaya apapun.
            </p>
            <div class="pt-2 max-w-md mx-auto">
                <a href="{{ route('warga.submissions.create', ['service' => $service->kode_layanan]) }}"
                   id="btnAjukanLayananBottom"
                   class="w-full py-3.5 px-6 rounded-xl font-extrabold text-sm sm:text-base text-white bg-[#0a2558] hover:bg-[#0d3070] transition-colors shadow-sm flex items-center justify-center gap-2 group text-center cursor-pointer">
                    <span>AJUKAN LAYANAN SEKARANG</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

    </main>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         3. FOOTER RINGKAS
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <footer class="bg-white text-slate-500 text-xs py-6 border-t border-slate-200 w-full mt-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
            <div>
                <p class="font-semibold text-slate-700">Dinas Komunikasi dan Informatika (Diskominfo) Kabupaten Tasikmalaya</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Portal Resmi Pelayanan Publik Terpadu 39 Kecamatan</p>
            </div>
            <p class="text-[11px] text-slate-400">
                &copy; {{ date('Y') }} Pemkab Tasikmalaya. Bebas Biaya (UU No. 24/2013).
            </p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
</body>
</html>
