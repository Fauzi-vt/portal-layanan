                {{-- ════════════════════════════════════════════════
                     STEP 1 — WILAYAH & PEMOHON
                ════════════════════════════════════════════════ --}}
                <div x-show="activeStep === 1" x-cloak class="step-panel space-y-4">

                    @if ($isKkBaru)
                        {{-- ── KK_BARU: STEP 1 DATA PEMOHON ── --}}
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="user-check" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-slate-900">Data Pemohon</h3>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            Data diri Anda sebagai pemohon layanan.
                                        </p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 self-start sm:self-auto">
                                    <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                                    <span>Data ini diambil dari profil akun Anda.</span>
                                </span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 mb-1.5">
                                        Nama Lengkap
                                    </label>
                                    <input type="text"
                                           value="{{ $user->name }}"
                                           readonly
                                           class="w-full text-xs font-bold uppercase rounded-xl border border-slate-200 py-2.5 px-3.5 bg-slate-50 text-slate-800 cursor-not-allowed select-none shadow-2xs">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-800 mb-1.5">
                                        NIK
                                    </label>
                                    <input type="text"
                                           value="{{ $user->nik ?? '' }}"
                                           readonly
                                           class="w-full font-mono text-xs font-bold rounded-xl border border-slate-200 py-2.5 px-3.5 bg-slate-50 text-slate-800 cursor-not-allowed select-none shadow-2xs">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-800 mb-1.5">
                                        Nomor HP
                                    </label>
                                    <input type="text"
                                           value="{{ $user->phone ?? '' }}"
                                           readonly
                                           class="w-full text-xs font-semibold rounded-xl border border-slate-200 py-2.5 px-3.5 bg-slate-50 text-slate-800 cursor-not-allowed select-none shadow-2xs">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-800 mb-1.5">
                                        Email
                                    </label>
                                    <input type="email"
                                           value="{{ $user->email ?? '' }}"
                                           readonly
                                           class="w-full text-xs font-semibold rounded-xl border border-slate-200 py-2.5 px-3.5 bg-slate-50 text-slate-800 cursor-not-allowed select-none shadow-2xs">
                                </div>
                            </div>

                            <p class="text-[11px] text-slate-500 pt-1">
                                Data ini diambil dari profil akun Anda. Apabila terdapat perubahan data, silakan perbarui pada pengaturan profil akun warga.
                            </p>
                        </div>

                        {{-- Wilayah Verifikasi Card --}}
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6 space-y-4">
                            <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">Kecamatan Tujuan Verifikasi</h3>
                                    <p class="text-[11px] text-slate-500">Pilih kantor kecamatan domisili tempat permohonan Kartu Keluarga baru ini diproses.</p>
                                </div>
                            </div>

                            <div>
                                <label for="kecamatan_id" class="block text-xs font-bold text-slate-800 mb-1.5">
                                    Kecamatan Verifikasi <span class="text-rose-600">*</span>
                                </label>
                                <select name="kecamatan_id" id="kecamatan_id" required
                                        class="w-full text-xs font-bold rounded-xl border border-slate-300 bg-white text-slate-900 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 focus:outline-none py-2.5 px-3.5 shadow-2xs">
                                    @foreach ($kecamatans as $kec)
                                        <option value="{{ $kec->id }}" {{ old('kecamatan_id', $user->kecamatan_id) == $kec->id ? 'selected' : '' }}>
                                            Kecamatan {{ $kec->nama_kecamatan }} ({{ $kec->kode_kecamatan }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-[11px] text-slate-500 mt-1.5">
                                    Pilih kecamatan tempat permohonan ini akan diproses. Biasanya sesuai dengan kecamatan domisili Anda.
                                </p>
                            </div>
                        </div>
                    @else
                        {{-- Info banner (Non-KK_BARU) --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex gap-3 items-start">
                            <i data-lucide="info" class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5"></i>
                            <div class="text-xs text-blue-800 leading-relaxed">
                                <strong>Identitas Pemohon.</strong> Data Pemohon terisi otomatis dari profil akun Anda. Pilih kecamatan tujuan verifikasi, lalu lanjutkan ke langkah berikutnya.
                            </div>
                        </div>

                        {{-- Kecamatan selector --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 sm:p-6 space-y-5">
                            <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                                <div class="w-7 h-7 rounded-lg bg-blue-600 text-white flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900">Wilayah Verifikasi</h3>
                            </div>

                            <div>
                                <label for="kecamatan_id" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                    Kecamatan Tujuan Verifikasi <span class="text-rose-500">*</span>
                                    <span class="ml-1 text-slate-400 font-normal">(39 Kecamatan Kabupaten Tasikmalaya)</span>
                                </label>
                                <select name="kecamatan_id" id="kecamatan_id" required
                                        class="w-full text-xs font-semibold rounded-xl border border-slate-300 bg-white text-slate-900 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 focus:outline-none py-2.5 px-3 shadow-sm">
                                    @foreach ($kecamatans as $kec)
                                        <option value="{{ $kec->id }}" {{ old('kecamatan_id', $user->kecamatan_id) == $kec->id ? 'selected' : '' }}>
                                            Kecamatan {{ $kec->nama_kecamatan }} ({{ $kec->kode_kecamatan }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-[11px] text-slate-500 mt-1.5">
                                    Pilih kecamatan tempat permohonan ini akan diproses. Biasanya sesuai dengan kecamatan domisili Anda.
                                </p>
                            </div>
                        </div>

                        {{-- Pemohon card --}}
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 sm:p-6 space-y-4">
                            <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                                <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="user-circle" class="w-3.5 h-3.5"></i>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900">Identitas Pemohon</h3>
                                <span class="ml-auto inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                                    <i data-lucide="lock" class="w-3 h-3"></i>
                                    Terisi dari profil akun
                                </span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 space-y-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-black text-sm flex-shrink-0">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-slate-900">{{ $user->name }}</p>
                                            <p class="text-[11px] text-slate-500 font-mono">NIK: {{ $user->nik ?? '—' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 space-y-1.5">
                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                        <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400 flex-shrink-0"></i>
                                        <span class="truncate">{{ $user->email }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                        <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400 flex-shrink-0"></i>
                                        <span>{{ $user->phone ?? '—' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-slate-600">
                                        <i data-lucide="home" class="w-3.5 h-3.5 text-slate-400 flex-shrink-0"></i>
                                        <span class="truncate">{{ $user->desa?->nama_desa ?? '—' }}, {{ $user->kecamatan?->nama_kecamatan ?? '—' }}</span>
                                    </div>
                                </div>
                            </div>

                            <p class="text-[11px] text-slate-500">
                                Data di atas diambil dari profil akun Anda secara otomatis dan tidak dapat diubah di sini.
                                Jika ada yang tidak sesuai, silakan perbarui melalui halaman <a href="#" class="text-blue-600 underline font-semibold">Profil Akun</a>.
                            </p>
                        </div>
                    @endif

                    {{-- Formulir fisik notice --}}
                    @if ($service->isHybrid() && $service->template_formulir_path)
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="flex items-start gap-3">
                                <span class="text-xl mt-0.5">📄</span>
                                <div>
                                    <p class="text-xs font-bold text-amber-900">Layanan Membutuhkan Formulir Fisik</p>
                                    <p class="text-[11px] text-amber-800 mt-0.5">Unduh template, minta tanda tangan & stempel desa, lalu unggah hasil scan di langkah Berkas Dokumen.</p>
                                </div>
                            </div>
                            <a href="#" onclick="alert('Template formulir siap diunduh.');" class="px-3.5 py-2 rounded-lg font-bold text-white text-xs bg-amber-600 hover:bg-amber-700 whitespace-nowrap shadow-sm">
                                Unduh Template PDF
                            </a>
                        </div>
                    @endif

                </div>

                {{-- ════════════════════════════════════════════════
                     FORMULIR DIGITAL (KK_BARU 5-step ATAU Service-specific form)
                ════════════════════════════════════════════════ --}}
                @if ($isKkBaru)
                    @include('warga.submissions.partials.form-f101')
                @elseif ($hasFormSection)
                <div x-show="activeStep === 2" x-cloak class="step-panel space-y-4">

                    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 flex gap-3 items-start">
                        <i data-lucide="clipboard-list" class="w-4 h-4 text-indigo-600 flex-shrink-0 mt-0.5"></i>
                        <div class="text-xs text-indigo-800 leading-relaxed">
                            <strong>Formulir Digital.</strong> Isi data dengan lengkap dan benar. Data yang diisi di sini setara dengan formulir resmi Dukcapil.
                        </div>
                    </div>

                    {{-- Service-specific form includes --}}
                    @if ($service->kode_layanan === 'KK_ADD')
                        @include('warga.submissions.partials.form-kk-add')
                    @elseif ($service->kode_layanan === 'KK_DEL')
                        @include('warga.submissions.partials.form-kk-del')
                    @elseif ($service->kode_layanan === 'PINDAH_SATU_DESA')
                        @include('warga.submissions.partials.form-pindah-satu-desa')
                    @elseif ($service->kode_layanan === 'PINDAH_ANTAR_DESA')
                        @include('warga.submissions.partials.form-pindah-antar-desa')
                    @elseif ($service->kode_layanan === 'PINDAH_ANTAR_KEC' || $service->kode_layanan === 'PINDAH' || $service->kode_layanan === 'DATANG')
                        @include('warga.submissions.partials.form-pindah-antar-kecamatan')
                    @elseif ($service->requirements->contains(fn($r) => str_contains($r->nama_persyaratan, 'F-1.01') || str_contains($r->nama_persyaratan, 'F-1.15')))
                        @include('warga.submissions.partials.form-f101')
                    @endif

                </div>
                @endif
