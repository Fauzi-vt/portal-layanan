<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Portal Layanan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #0a0f1e; color: white; }

        .role-badge {
            @apply inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold;
        }

        .glass {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(16px);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="glass rounded-2xl p-10 max-w-md w-full text-center space-y-6">
        {{-- Role indicator --}}
        @php
            $roleColors = [
                'user'             => ['bg' => 'bg-blue-500/10',    'text' => 'text-blue-300',    'dot' => 'bg-blue-400'],
                'admin_kecamatan'  => ['bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-300', 'dot' => 'bg-emerald-400'],
                'admin_kabupaten'  => ['bg' => 'bg-amber-500/10',   'text' => 'text-amber-300',   'dot' => 'bg-amber-400'],
                'super_admin'      => ['bg' => 'bg-rose-500/10',    'text' => 'text-rose-300',    'dot' => 'bg-rose-400'],
            ];
            $role   = auth()->user()->role->value;
            $colors = $roleColors[$role] ?? $roleColors['user'];
        @endphp

        <div class="w-16 h-16 rounded-2xl mx-auto flex items-center justify-center bg-blue-500/10 border border-blue-500/20">
            <svg class="w-8 h-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
        </div>

        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold mb-3 {{ $colors['bg'] }} {{ $colors['text'] }}">
                <span class="w-1.5 h-1.5 rounded-full {{ $colors['dot'] }}"></span>
                {{ auth()->user()->role->label() }}
            </span>
            <h1 class="text-2xl font-bold text-white">Halo, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-slate-400 text-sm mt-2">Anda berhasil masuk sebagai <strong class="{{ $colors['text'] }}">{{ auth()->user()->role->label() }}</strong></p>
        </div>

        <div class="border-t border-white/8 pt-6">
            <p class="text-slate-500 text-xs mb-4">Dashboard untuk role ini sedang dalam pengembangan</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full py-2.5 px-4 rounded-xl text-sm font-semibold text-white
                    bg-white/5 hover:bg-white/10 border border-white/10
                    transition-all duration-200">
                    Keluar dari Portal
                </button>
            </form>
        </div>
    </div>
</body>
</html>
