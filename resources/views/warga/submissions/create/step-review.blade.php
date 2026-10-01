                {{-- ════════════════════════════════════════════════
                     STEP 4 (or 3 if no form) — TINJAU & AJUKAN
                {{-- ════════════════════════════════════════════════
                     REVIEW & AJUKAN (Step 5 jika KK_BARU, 4 jika form lain, 3 jika tanpa form)
                ════════════════════════════════════════════════ --}}
                @php $reviewStep = $isKkBaru ? 5 : ($hasFormSection ? 4 : 3); @endphp
                <div x-show="activeStep === {{ $reviewStep }}" x-cloak class="step-panel space-y-4">

                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex gap-3 items-start">
                        <i data-lucide="eye" class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5"></i>
                        <div class="text-xs text-amber-800 leading-relaxed">
                            <strong>{{ $isKkBaru ? 'Review Permohonan.' : 'Tinjau sebelum mengajukan.' }}</strong> Pastikan semua informasi sudah benar sebelum mengirimkan permohonan. Anda dapat mengklik tombol <strong>Ubah</strong> pada masing-masing bagian jika ada data yang perlu diperbaiki.
                        </div>
                    </div>

                    @if ($isKkBaru)
                        {{-- Review KK_BARU: 1. Data Pemohon --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-700 to-blue-600 px-5 py-3 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="user" class="w-4 h-4 text-blue-200"></i>
                                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">1. Data Pemohon</h3>
                                </div>
                                <button type="button" @click="goToStep(1)" class="text-xs font-bold text-blue-100 hover:text-white underline cursor-pointer flex items-center gap-1">
                                    <i data-lucide="edit-3" class="w-3 h-3"></i>
                                    Ubah
                                </button>
                            </div>
                            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 text-xs">
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Nama Pemohon</p>
                                    <p class="font-bold text-slate-900">{{ $user->name }}</p>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">NIK Pemohon</p>
                                    <p class="font-bold text-slate-900 font-mono">{{ $user->nik ?? '—' }}</p>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Kontak</p>
                                    <p class="font-bold text-slate-900">{{ $user->email }} / {{ $user->phone ?? '—' }}</p>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Kecamatan Verifikasi</p>
                                    <p class="font-bold text-slate-900" id="review-kecamatan-display">
                                        @php
                                            $defaultKec = $kecamatans->firstWhere('id', old('kecamatan_id', $user->kecamatan_id));
                                        @endphp
                                        {{ $defaultKec ? 'Kec. ' . $defaultKec->nama_kecamatan : '—' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Review KK_BARU: 2. Data Kepala Keluarga & Alamat --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-indigo-700 to-indigo-600 px-5 py-3 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="home" class="w-4 h-4 text-indigo-200"></i>
                                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">2. Kepala Keluarga & Alamat</h3>
                                </div>
                                <button type="button" @click="goToStep(2)" class="text-xs font-bold text-indigo-100 hover:text-white underline cursor-pointer flex items-center gap-1">
                                    <i data-lucide="edit-3" class="w-3 h-3"></i>
                                    Ubah
                                </button>
                            </div>
                            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-xs">
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Nama Kepala Keluarga</p>
                                    <p class="font-bold text-slate-900 text-sm uppercase" x-text="$store.kkBaru?.meta?.nama_kepala_keluarga || '—'"></p>
                                </div>
                                <div class="space-y-0.5 sm:col-span-2">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Alamat Tempat Tinggal</p>
                                    <p class="font-semibold text-slate-800" x-text="($store.kkBaru?.meta?.alamat || '—') + ' (RT ' + ($store.kkBaru?.meta?.rt || '001') + ' / RW ' + ($store.kkBaru?.meta?.rw || '001') + ')'"></p>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Desa / Kelurahan</p>
                                    <p class="font-bold text-slate-900 uppercase" x-text="$store.kkBaru?.meta?.desa || '—'"></p>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Kecamatan</p>
                                    <p class="font-bold text-slate-900 uppercase" x-text="$store.kkBaru?.meta?.kecamatan || '—'"></p>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Kode Pos & Wilayah</p>
                                    <p class="font-bold text-slate-900 font-mono" x-text="($store.kkBaru?.meta?.kode_pos || '—') + ', ' + ($store.kkBaru?.meta?.kabupaten || 'KAB. TASIKMALAYA')"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Review KK_BARU: 3. Anggota Keluarga --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-teal-700 to-teal-600 px-5 py-3 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="users" class="w-4 h-4 text-teal-200"></i>
                                    <h3 class="text-xs font-bold text-white uppercase tracking-wider">
                                        3. Anggota Keluarga (<span x-text="$store.kkBaru?.anggota?.length || 0"></span> Orang)
                                    </h3>
                                </div>
                                <button type="button" @click="goToStep(3)" class="text-xs font-bold text-teal-100 hover:text-white underline cursor-pointer flex items-center gap-1">
                                    <i data-lucide="edit-3" class="w-3 h-3"></i>
                                    Ubah
                                </button>
                            </div>
                            <div class="p-5 divide-y divide-slate-100 space-y-2.5">
                                <template x-for="(m, idx) in ($store.kkBaru?.anggota || [])" :key="'rev-mem-' + idx">
                                    <div class="pt-2.5 first:pt-0 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                                        <div class="flex items-center gap-3">
                                            <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-700 font-bold text-[10px] flex items-center justify-center" x-text="idx + 1"></span>
                                            <div>
                                                <span class="font-bold text-slate-900 uppercase" x-text="m.nama"></span>
                                                <span class="text-slate-400 font-mono text-[11px] ml-1.5" x-text="'(NIK: ' + ($store.kkBaru?.maskNik(m.nik) || m.nik) + ')'"></span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 pl-9 sm:pl-0">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold"
                                                  :class="$store.kkBaru?.getShdkBadgeClass(m.shdk)"
                                                  x-text="m.shdk"></span>
                                            <span class="text-slate-500 text-[11px]" x-text="m.jenis_kelamin"></span>
                                            <template x-if="m.tanggal_lahir">
                                                <span class="text-slate-400 text-[11px]" x-text="'• ' + ($store.kkBaru?.calculateAge(m.tanggal_lahir) || '')"></span>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    @else
                        {{-- Review: Layanan (Non-KK_BARU) --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-slate-800 to-slate-700 px-5 py-3 flex items-center gap-2">
                                <i data-lucide="briefcase" class="w-4 h-4 text-slate-300"></i>
                                <h3 class="text-xs font-bold text-white uppercase tracking-wider">Layanan yang Dipilih</h3>
                            </div>
                            <div class="p-5 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 flex items-center justify-center flex-shrink-0">
                                    @if ($service->kode_layanan === 'KIA') <i data-lucide="contact" class="w-5 h-5"></i>
                                    @elseif ($service->kode_layanan === 'EKTP') <i data-lucide="camera" class="w-5 h-5"></i>
                                    @elseif ($service->kode_layanan === 'KK_BARU') <i data-lucide="users" class="w-5 h-5"></i>
                                    @elseif ($service->kode_layanan === 'KK_ADD') <i data-lucide="user-plus" class="w-5 h-5"></i>
                                    @elseif ($service->kode_layanan === 'KK_DEL') <i data-lucide="user-minus" class="w-5 h-5"></i>
                                    @elseif (str_starts_with($service->kode_layanan, 'PINDAH') || $service->kode_layanan === 'DATANG') <i data-lucide="truck" class="w-5 h-5"></i>
                                    @elseif ($service->kode_layanan === 'NIKAH') <i data-lucide="heart" class="w-5 h-5"></i>
                                    @else <i data-lucide="file-text" class="w-5 h-5"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-900">{{ $service->nama_layanan }}</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5">{{ $service->deskripsi }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Review: Pemohon (Non-KK_BARU) --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-700 to-blue-600 px-5 py-3 flex items-center gap-2">
                                <i data-lucide="user" class="w-4 h-4 text-blue-200"></i>
                                <h3 class="text-xs font-bold text-white uppercase tracking-wider">Data Pemohon & Wilayah</h3>
                            </div>
                            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                <div class="review-section pl-3 space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Nama Lengkap</p>
                                    <p class="font-bold text-slate-900">{{ $user->name }}</p>
                                </div>
                                <div class="review-section pl-3 space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">NIK</p>
                                    <p class="font-bold text-slate-900 font-mono">{{ $user->nik ?? '—' }}</p>
                                </div>
                                <div class="review-section pl-3 space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Kecamatan Verifikasi</p>
                                    <p class="font-bold text-slate-900" id="review-kecamatan-display">
                                        @php
                                            $defaultKec = $kecamatans->firstWhere('id', old('kecamatan_id', $user->kecamatan_id));
                                        @endphp
                                        {{ $defaultKec ? 'Kec. ' . $defaultKec->nama_kecamatan : '—' }}
                                    </p>
                                </div>
                                <div class="review-section pl-3 space-y-0.5">
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Email / WhatsApp</p>
                                    <p class="font-bold text-slate-900">{{ $user->email }} / {{ $user->phone ?? '—' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Review: Dokumen --}}
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="bg-gradient-to-r from-violet-700 to-violet-600 px-5 py-3 flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <i data-lucide="files" class="w-4 h-4 text-violet-200"></i>
                                <h3 class="text-xs font-bold text-white uppercase tracking-wider">
                                    {{ $isKkBaru ? '4. Dokumen Pendukung' : 'Berkas Persyaratan' }}
                                </h3>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-[10px] text-violet-200 font-semibold">
                                    {{ $service->requirements->count() }} Persyaratan
                                </span>
                                @if ($isKkBaru)
                                    <button type="button" @click="goToStep(4)" class="text-xs font-bold text-violet-100 hover:text-white underline cursor-pointer flex items-center gap-1">
                                        <i data-lucide="edit-3" class="w-3 h-3"></i>
                                        Ubah
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="p-5 space-y-2.5">
                            @foreach ($service->requirements as $req)
                                @php
                                    $isF1DocRev = str_contains($req->nama_persyaratan, 'F-1.01')
                                        || str_contains($req->nama_persyaratan, 'F-1.15')
                                        || str_contains($req->nama_persyaratan, 'Formulir');
                                @endphp
                                <div class="flex items-center gap-3 text-xs py-2.5 border-b border-slate-50 last:border-0">
                                    <div x-show="!filePreviews[{{ $req->id }}] && !{{ $isF1DocRev && $hasFormSection ? 'true' : 'false' }}"
                                         class="w-5 h-5 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="minus" class="w-3 h-3"></i>
                                    </div>
                                    <div x-show="filePreviews[{{ $req->id }}]"
                                         class="w-5 h-5 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="check" class="w-3 h-3"></i>
                                    </div>
                                    @if ($isF1DocRev && $hasFormSection)
                                    <div x-show="!filePreviews[{{ $req->id }}]"
                                         class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="check-check" class="w-3 h-3"></i>
                                    </div>
                                    @endif
                                    <div class="flex-1 flex items-center justify-between gap-3">
                                        <span class="text-slate-700 font-semibold">{{ $req->nama_persyaratan }}</span>
                                        <span x-show="filePreviews[{{ $req->id }}]"
                                              class="text-green-700 font-bold text-[10px]"
                                              x-text="'✓ ' + (filePreviews[{{ $req->id }}]?.name || '')"></span>
                                        @if ($isF1DocRev && $hasFormSection)
                                            <span x-show="!filePreviews[{{ $req->id }}]"
                                                  class="text-emerald-700 font-bold text-[10px]">✓ Diisi online</span>
                                        @elseif (!$req->is_required)
                                            <span x-show="!filePreviews[{{ $req->id }}]"
                                                  class="text-slate-400 font-semibold text-[10px]">Opsional</span>
                                        @else
                                            <span x-show="!filePreviews[{{ $req->id }}]"
                                                  class="text-rose-600 font-bold text-[10px]">⚠ Belum diunggah</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Final call-to-action --}}
                    <div class="bg-gradient-to-br from-blue-900 to-indigo-900 rounded-2xl p-6 sm:p-8 text-center space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-white/10 text-white flex items-center justify-center mx-auto">
                            <i data-lucide="send" class="w-7 h-7"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-white">Siap Mengajukan?</h3>
                            <p class="text-xs text-blue-200 mt-1 max-w-md mx-auto">
                                Periksa kembali data di atas. Setelah diajukan, permohonan akan diproses oleh petugas kecamatan atau desa.
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-1">
                            <button type="button"
                                    :disabled="submitting"
                                    @click="submitForm('0')"
                                    class="w-full sm:w-auto px-6 py-3 rounded-xl font-bold text-sm text-white bg-white/10 border border-white/20 hover:bg-white/20 transition-all disabled:opacity-50 cursor-pointer flex items-center justify-center gap-2">
                                <i data-lucide="bookmark" class="w-4 h-4"></i>
                                Simpan sebagai Draft
                            </button>
                            <button type="button"
                                    :disabled="submitting"
                                    @click="submitForm('1')"
                                    class="w-full sm:w-auto px-8 py-3 rounded-xl font-black text-sm text-blue-900 bg-white hover:bg-blue-50 transition-all shadow-lg disabled:opacity-50 cursor-pointer flex items-center justify-center gap-2">
                                <span x-show="!submitting">Ajukan Permohonan</span>
                                <span x-show="submitting">Mengirim…</span>
                                <i data-lucide="send" class="w-4 h-4" x-show="!submitting"></i>
                                <svg x-show="submitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>
