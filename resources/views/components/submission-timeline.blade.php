@props(['histories'])

<div class="bg-white rounded-3xl p-6 border border-slate-200 portal-shadow space-y-4">
    <div class="flex items-center justify-between">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Riwayat & Catatan Audit Permohonan
        </h3>
        <span class="text-[11px] font-semibold text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full">
            {{ $histories->count() }} Peristiwa
        </span>
    </div>

    @if ($histories->isEmpty())
        <div class="text-center py-6 text-slate-400 text-xs italic">
            Belum ada riwayat aktivitas tercatat pada permohonan ini.
        </div>
    @else
        <div class="relative pl-6 sm:pl-8 mt-4 space-y-6 before:absolute before:left-3 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
            @foreach ($histories as $history)
                @php
                    $badgeColor = match($history->action) {
                        'created', 'submitted', 'revision_submitted' => 'bg-blue-500 ring-blue-100 text-white',
                        'verified_desa_approved', 'reviewed_kecamatan' => 'bg-indigo-500 ring-indigo-100 text-white',
                        'completed' => 'bg-emerald-500 ring-emerald-100 text-white',
                        'biometric_scheduled' => 'bg-sky-500 ring-sky-100 text-white',
                        'verified_desa_revision' => 'bg-amber-500 ring-amber-100 text-white',
                        'verified_desa_rejected', 'rejected' => 'bg-rose-500 ring-rose-100 text-white',
                        default => 'bg-slate-500 ring-slate-100 text-white',
                    };

                    $actionLabel = match($history->action) {
                        'created' => 'Permohonan Dibuat (Draft)',
                        'submitted' => 'Permohonan Diajukan ke Petugas',
                        'revision_submitted' => 'Berkas Revisi Berhasil Diunggah Pemohon',
                        'verified_desa_approved' => 'Verifikasi Desa Disetujui & Diteruskan ke Kecamatan',
                        'verified_desa_revision' => 'Pemeriksaan Desa Membutuhkan Revisi Berkas',
                        'verified_desa_rejected' => 'Permohonan Ditolak di Tingkat Desa',
                        'reviewed_kecamatan' => 'Pemeriksaan & Validasi Dokumen di Kecamatan',
                        'biometric_scheduled' => 'Jadwal Rekam Biometrik e-KTP Diterbitkan',
                        'completed' => 'Permohonan Selesai & Dokumen Diterbitkan',
                        'rejected' => 'Permohonan Ditolak Resmi di Kecamatan',
                        default => ucwords(str_replace('_', ' ', $history->action)),
                    };
                @endphp
                <div class="relative group">
                    {{-- Timeline Dot --}}
                    <div class="absolute -left-6 sm:-left-8 top-1.5 w-6 h-6 rounded-full {{ $badgeColor }} ring-4 flex items-center justify-center text-[10px] font-bold shadow-sm">
                        @if (str_contains($history->action, 'completed'))
                            ✓
                        @elseif (str_contains($history->action, 'rejected'))
                            ✕
                        @elseif (str_contains($history->action, 'revision'))
                            !
                        @elseif (str_contains($history->action, 'biometric'))
                            📷
                        @else
                            •
                        @endif
                    </div>

                    <div class="bg-slate-50/80 hover:bg-slate-50 transition-colors rounded-2xl p-4 border border-slate-200/80 space-y-2">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                            <h4 class="text-xs font-bold text-slate-800">{{ $actionLabel }}</h4>
                            <time class="text-[11px] text-slate-500 font-medium">
                                {{ $history->created_at->isoFormat('D MMMM Y, HH:mm') }} WIB
                            </time>
                        </div>

                        <div class="flex items-center gap-2 text-[11px] text-slate-500">
                            <span>Diproses oleh:</span>
                            <span class="font-semibold text-slate-700">
                                {{ $history->user?->name ?? 'Sistem / Pemohon' }}
                            </span>
                            @if ($history->user)
                                <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider bg-slate-200/70 text-slate-600">
                                    {{ $history->user->role?->label() ?? $history->user->role }}
                                </span>
                            @endif
                        </div>

                        @if ($history->from_status || $history->to_status)
                            <div class="text-[10px] text-slate-500 flex items-center gap-1.5 pt-1">
                                <span>Status:</span>
                                <span class="font-mono bg-white px-1.5 py-0.5 rounded border border-slate-200 text-slate-600">
                                    {{ $history->from_status ?? '-' }}
                                </span>
                                <span>&rarr;</span>
                                <span class="font-mono font-bold bg-slate-900 px-1.5 py-0.5 rounded text-white">
                                    {{ $history->to_status }}
                                </span>
                            </div>
                        @endif

                        @if ($history->notes)
                            <div class="p-3 bg-white rounded-xl border border-slate-200/70 text-xs text-slate-700 font-medium whitespace-pre-line mt-2 shadow-2xs">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Catatan Petugas / Sistem:</span>
                                {{ $history->notes }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
