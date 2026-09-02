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

        // Simpan ke storage 'public' disk
        $path = $file->storeAs($directory, $uniqueName, 'public');

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
     * Simpan e-dokumen hasil/output dari petugas kecamatan setelah selesai.
     */
    public function storeOutputDocument(UploadedFile $file, int $submissionId): string
    {
        $directory = "submissions/{$submissionId}/output";
        $extension = $file->getClientOriginalExtension();
        $fileName = "e_dokumen_hasil_" . Str::random(8) . ".{$extension}";

        return $file->storeAs($directory, $fileName, 'public');
    }

    /**
     * Hapus berkas fisik dari storage jika permohonan/berkas dibatalkan.
     */
    public function deleteDocumentFile(?string $path): bool
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }
}
