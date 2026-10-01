@php
    // Siapkan daftar kecamatan beserta desa untuk autocomplete otomatis
    $kecamatanMap = ($kecamatans ?? collect())->mapWithKeys(function($k) {
        return [
            strtoupper($k->nama_kecamatan) => $k->desas ? $k->desas->pluck('nama_desa')->map(fn($d) => strtoupper($d))->values() : []
        ];
    });

    $userKecName = strtoupper($user->kecamatan?->nama_kecamatan ?? 'SINGAPARNA');
    $defaultDesa = strtoupper($user->desa?->nama_desa ?? '');
    $existingF101 = old('form_data.f101', isset($submission) ? ($submission->form_data['f101'] ?? null) : null);
@endphp

{{-- ═══════════════════════════════════════════════════════════════════════
     F-1.01 — PERMOHONAN KARTU KELUARGA BARU
     Orchestrator: memuat sub-partials berdasarkan tanggung jawab masing-masing.
═══════════════════════════════════════════════════════════════════════ --}}

{{-- Store Alpine.js kkBaru — harus dimuat pertama sebelum UI --}}
@include('warga.submissions.partials.f101.store-scripts')

<div id="kk-baru-root" class="space-y-6 font-sans">

    {{-- Panel 1: Data Kepala Keluarga & Alamat Tempat Tinggal --}}
    @include('warga.submissions.partials.f101.panel-kepala-keluarga')

    {{-- Panel 2: Tabel / Card Repeater Anggota Keluarga --}}
    @include('warga.submissions.partials.f101.tabel-anggota-keluarga')

    {{-- Modal Dialog: Tambah / Ubah Anggota Keluarga --}}
    @include('warga.submissions.partials.f101.modal-anggota-keluarga')

    {{-- Serialisasi Hidden Inputs (kontrak backend form_data.f101) --}}
    <div class="hidden" aria-hidden="true">
        <input type="hidden" name="form_data[f101][nama_pemohon]" :value="$store.kkBaru.meta.nama_pemohon || '{{ $user->name }}'">
        <input type="hidden" name="form_data[f101][nik_pemohon]" :value="$store.kkBaru.meta.nik_pemohon || '{{ $user->nik }}'">
        <input type="hidden" name="form_data[f101][nama_kepala_keluarga]" :value="$store.kkBaru.meta.nama_kepala_keluarga">
        <input type="hidden" name="form_data[f101][alamat]" :value="$store.kkBaru.meta.alamat">
        <input type="hidden" name="form_data[f101][rt]" :value="$store.kkBaru.meta.rt">
        <input type="hidden" name="form_data[f101][rw]" :value="$store.kkBaru.meta.rw">
        <input type="hidden" name="form_data[f101][kode_pos]" :value="$store.kkBaru.meta.kode_pos">
        <input type="hidden" name="form_data[f101][nama_kecamatan]" :value="$store.kkBaru.meta.kecamatan">
        <input type="hidden" name="form_data[f101][nama_desa]" :value="$store.kkBaru.meta.desa">
        <input type="hidden" name="form_data[f101][nama_kabupaten]" :value="$store.kkBaru.meta.kabupaten">
        <input type="hidden" name="form_data[f101][nama_provinsi]" :value="$store.kkBaru.meta.provinsi">
        <input type="hidden" name="form_data[f101][negara]" :value="$store.kkBaru.meta.negara">
        <input type="hidden" name="form_data[f101][jumlah_anggota]" :value="$store.kkBaru.anggota.length">

        <template x-for="(item, index) in $store.kkBaru.anggota" :key="'f101-serialized-' + index">
            <div>
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][nama]'" :value="item.nama">
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][nik]'" :value="item.nik">
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][jenis_kelamin]'" :value="item.jenis_kelamin">
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][tempat_lahir]'" :value="item.tempat_lahir">
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][tanggal_lahir]'" :value="item.tanggal_lahir">
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][agama]'" :value="item.agama">
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][pendidikan]'" :value="item.pendidikan">
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][pekerjaan]'" :value="item.pekerjaan">
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][gol_darah]'" :value="item.gol_darah">
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][status_kawin]'" :value="item.status_kawin">
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][tgl_kawin]'" :value="item.tgl_kawin">
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][shdk]'" :value="item.shdk">
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][kewarganegaraan]'" :value="item.kewarganegaraan">
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][no_paspor]'" :value="item.no_paspor">
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][no_kitap]'" :value="item.no_kitap">
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][nama_ayah]'" :value="item.nama_ayah">
                <input type="hidden" :name="'form_data[f101][anggota][' + index + '][nama_ibu]'" :value="item.nama_ibu">
            </div>
        </template>
    </div>

</div>