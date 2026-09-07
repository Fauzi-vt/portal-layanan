<?php

namespace App\Services;

use App\Models\ServiceRequirement;
use App\Models\SubmissionDocument;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentUploadService
{
    /**
     * Simpan file berkas persyaratan yang diunggah warga ke disk storage.
     *
     * @param UploadedFile $file
     * @param int $submissionId
     * @param ServiceRequirement $requirement
     * @return SubmissionDocument
     */
    public function storeRequirementDocument(
        UploadedFile $file,
        int $submissionId,
        ServiceRequirement $requirement
    ): SubmissionDocument {
        // Tentukan folder penyimpanan: submissions/{submissionId}/documents
        $directory = "submissions/{$submissionId}/documents";

        // Buat nama file aman dengan UUID
        $extension = $file->getClientOriginalExtension();
        $safeFileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $uniqueName = "{$requirement->id}_{$safeFileName}_" . Str::random(8) . ".{$extension}";

        // Simpan ke private storage 'local' disk (terproteksi di luar web root)
        $path = $file->storeAs($directory, $uniqueName, 'local');

        // Update atau buat record berkas di database
        $document = SubmissionDocument::updateOrCreate(
            [
                'submission_id'          => $submissionId,
                'service_requirement_id' => $requirement->id,
            ],
            [
                'file_path'       => $path,
                'file_name'       => $file->getClientOriginalName(),
                'file_size'       => $file->getSize(),
                'mime_type'       => $file->getMimeType(),
                'status_validasi' => \App\Enums\DocumentValidationStatus::Pending,
                'catatan_dokumen' => null, // Reset catatan saat diupload ulang
            ]
        );

        return $document;
    }

    /**
     * Simpan e-dokumen hasil/output dari petugas kecamatan setelah selesai ke private disk.
     */
    public function storeOutputDocument(UploadedFile $file, int $submissionId): string
    {
        $directory = "submissions/{$submissionId}/output";
        $extension = $file->getClientOriginalExtension();
        $fileName = "e_dokumen_hasil_" . Str::random(8) . ".{$extension}";

        return $file->storeAs($directory, $fileName, 'local');
    }

    /**
     * Hapus berkas fisik dari storage jika permohonan/berkas dibatalkan.
     */
    public function deleteDocumentFile(?string $path): bool
    {
        if (! $path) {
            return false;
        }

        if (Storage::disk('local')->exists($path)) {
            return Storage::disk('local')->delete($path);
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }

    /**
     * Buat file PDF resmi default jika dokumen hasil belum ada di disk storage.
     */
    public function generateDefaultOutputPdf(\App\Models\Submission $submission): string
    {
        $directory = "submissions/{$submission->id}/output";
        $path = $submission->output_document_path ?: "{$directory}/e_dokumen_hasil_{$submission->nomor_tiket}.pdf";

        $namaWarga = addslashes($submission->user->name ?? 'Pemohon');
        $nikWarga = $submission->user->nik ?? '-';
        $layanan = addslashes($submission->service->nama_layanan ?? 'Pelayanan Administrasi Kependudukan');
        $kecamatan = addslashes($submission->kecamatan->nama_kecamatan ?? 'Manonjaya');
        $tiket = $submission->nomor_tiket;
        $tgl = date('d F Y');

        $textStream = "BT\n/F1 16 Tf\n50 780 Td\n(PEMERINTAH KABUPATEN TASIKMALAYA) Tj\n/F1 13 Tf\n0 -22 Td\n(KANTOR KECAMATAN {$kecamatan}) Tj\n/F1 9 Tf\n0 -20 Td\n(SURAT KETERANGAN RESMI HASIL PELAYANAN ADMINISTRASI) Tj\n/F1 10 Tf\n0 -30 Td\n(Nomor Tiket: {$tiket}) Tj\n0 -16 Td\n(Jenis Layanan: {$layanan}) Tj\n0 -16 Td\n(Status Permohonan: SELESAI / RESMI DITERBITKAN) Tj\n0 -25 Td\n(Data Pemohon:) Tj\n0 -16 Td\n(Nama Pemohon : {$namaWarga}) Tj\n0 -16 Td\n(NIK Pemohon  : {$nikWarga}) Tj\n0 -16 Td\n(Wilayah      : Kecamatan {$kecamatan}) Tj\n0 -30 Td\n(Permohonan telah diverifikasi secara sah dan disetujui oleh Petugas Kecamatan.) Tj\n0 -16 Td\n(Dokumen administrasi kependudukan Anda telah berhasil diproses.) Tj\n0 -35 Td\n(Diterbitkan di Kecamatan {$kecamatan}, pada {$tgl}) Tj\n0 -35 Td\n(Petugas Administrasi Kecamatan) Tj\n0 -45 Td\n([ Tanda Tangan & Cap Digital Sah ]) Tj\nET\n";

        $streamLen = strlen($textStream);

        $pdf = "%PDF-1.4\n"
            . "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n"
            . "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n"
            . "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj\n"
            . "4 0 obj\n<< /Length {$streamLen} >>\nstream\n{$textStream}\nendstream\nendobj\n"
            . "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n"
            . "xref\n0 6\n0000000000 65535 f \n"
            . "0000000009 00000 n \n"
            . "0000000058 00000 n \n"
            . "0000000115 00000 n \n"
            . "0000000236 00000 n \n"
            . sprintf("%010d 00000 n \n", 236 + 65 + $streamLen)
            . "trailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n" . (310 + $streamLen) . "\n%%EOF\n";

        Storage::disk('local')->put($path, $pdf);

        return $path;
    }
}
