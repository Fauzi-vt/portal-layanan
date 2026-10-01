                {{-- ════════════════════════════════════════════════
                     BERKAS DOKUMEN (Step 4 jika KK_BARU, 3 jika form lain, 2 jika tanpa form)
                ════════════════════════════════════════════════ --}}
                @php $docStep = $isKkBaru ? 4 : ($hasFormSection ? 3 : 2); @endphp
                <div x-show="activeStep === {{ $docStep }}" x-cloak class="step-panel space-y-4">

                    @if ($isKkBaru)
                        {{-- KK_BARU Header Card --}}
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-700 border border-violet-100 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="paperclip" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-slate-900">Dokumen Pendukung</h3>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            Lengkapi dokumen berikut untuk melanjutkan permohonan.
                                        </p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-violet-50 text-violet-700 border border-violet-200 self-start sm:self-auto">
                                    <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                                    <span>{{ $service->requirements->count() }} Persyaratan Dokumen</span>
                                </span>
                            </div>

                            <p class="text-xs text-slate-600 leading-relaxed">
                                Dokumen dengan tanda <strong class="text-rose-600">Dokumen wajib</strong> wajib dilampirkan sebelum mengirimkan permohonan. Format berkas yang didukung: PDF, JPG, PNG (maksimal 5 MB per berkas).
                            </p>
                        </div>
                    @else
                        <div class="bg-violet-50 border border-violet-200 rounded-xl p-4 flex gap-3 items-start">
                            <i data-lucide="paperclip" class="w-4 h-4 text-violet-600 flex-shrink-0 mt-0.5"></i>
                            <div class="text-xs text-violet-800 leading-relaxed">
                                <strong>Unggah Berkas Persyaratan.</strong> Dokumen yang ditandai <span class="font-bold text-rose-600">Wajib</span> harus diunggah sebelum mengajukan permohonan. Ukuran file maks 5 MB (PDF, JPG, PNG).
                            </div>
                        </div>
                    @endif

                    <div class="space-y-3">
                        @foreach ($service->requirements as $req)
                            @php
                                $isF1Doc = str_contains($req->nama_persyaratan, 'F-1.01')
                                    || str_contains($req->nama_persyaratan, 'F-1.15')
                                    || str_contains($req->nama_persyaratan, 'Formulir');
                            @endphp

                            <div class="doc-upload-card bg-white rounded-2xl border border-slate-200 shadow-sm p-4 sm:p-5 space-y-3 transition-all"
                                 :class="{ 'has-file border-emerald-300 bg-emerald-50/20': filePreviews[{{ $req->id }}] }">
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                                    <div class="flex items-start gap-3 flex-1">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5"
                                             :class="filePreviews[{{ $req->id }}] ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : '{{ $isF1Doc ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($req->is_required ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-slate-50 text-slate-500 border border-slate-200') }}'">
                                            <template x-if="filePreviews[{{ $req->id }}]">
                                                <i data-lucide="check" class="w-5 h-5"></i>
                                            </template>
                                            <template x-if="!filePreviews[{{ $req->id }}]">
                                                <i data-lucide="{{ $isF1Doc ? 'file-check' : 'file-up' }}" class="w-5 h-5"></i>
                                            </template>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h4 class="text-xs sm:text-sm font-bold text-slate-900">{{ $req->nama_persyaratan }}</h4>
                                                @if ($isF1Doc)
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">✓ Diisi Online — Opsional</span>
                                                @elseif ($req->is_required)
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700 border border-rose-200">Dokumen wajib</span>
                                                @else
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">Dokumen opsional</span>
                                                @endif
                                            </div>
                                            @if ($req->deskripsi)
                                                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">{{ $req->deskripsi }}</p>
                                            @endif
                                            @if ($isF1Doc && $hasFormSection)
                                                <p class="text-[11px] text-emerald-700 mt-1 font-medium">
                                                    Karena Anda telah mengisi formulir digital, unggah scan fisik bersifat opsional. Anda tetap dapat melampirkannya jika tersedia.
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Status Badge --}}
                                    <div class="flex-shrink-0 self-start sm:self-center">
                                        <template x-if="filePreviews[{{ $req->id }}]">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                                                <span>Sudah diunggah</span>
                                            </span>
                                        </template>
                                        <template x-if="!filePreviews[{{ $req->id }}]">
                                            @if ($isF1Doc && $hasFormSection)
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                                    <span>Sudah diisi online</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold {{ $req->is_required ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                                    <i data-lucide="circle" class="w-3.5 h-3.5"></i>
                                                    <span>Belum diunggah</span>
                                                </span>
                                            @endif
                                        </template>
                                    </div>
                                </div>

                                {{-- File preview info --}}
                                <div x-show="filePreviews[{{ $req->id }}]" x-cloak
                                     class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 rounded-xl px-3.5 py-2">
                                    <i data-lucide="file-check-2" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                                    <span class="text-xs text-emerald-800 font-semibold truncate" x-text="filePreviews[{{ $req->id }}]?.name"></span>
                                    <span class="text-[11px] text-emerald-600 ml-auto flex-shrink-0 font-mono" x-text="filePreviews[{{ $req->id }}]?.size"></span>
                                </div>

                                <label class="flex items-center gap-3 cursor-pointer group pt-1">
                                    <div class="flex-1">
                                        <input type="file"
                                               id="doc_{{ $req->id }}"
                                               name="documents[{{ $req->id }}]"
                                               accept=".pdf,.jpg,.jpeg,.png"
                                               {{ ($req->is_required && !$isF1Doc) ? 'required' : '' }}
                                               @change="handleFileChange({{ $req->id }}, $event)"
                                               class="block w-full text-xs text-slate-700
                                                      file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0
                                                      file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700
                                                      hover:file:bg-blue-100 file:cursor-pointer
                                                      border border-dashed border-slate-300 rounded-xl bg-slate-50/50
                                                      focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-400
                                                      transition-all p-2 group-hover:border-blue-400">
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>

                </div>
