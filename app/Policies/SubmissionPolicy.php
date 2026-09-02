<?php

namespace App\Policies;

use App\Enums\SubmissionStatus;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * SubmissionPolicy
 *
 * Menerapkan isolasi data ketat berbasis Multi-Tenant / Multi-Kecamatan scope:
 * - Super Admin    : Memiliki akses menyeluruh (Global Monitoring).
 * - Admin Kecamatan: HANYA dapat melihat & memverifikasi pengajuan di kecamatannya sendiri.
 * - Warga / User   : HANYA dapat melihat pengajuan miliknya, dan hanya bisa mengedit jika berstatus draft / revision_required.
 */
class SubmissionPolicy
{
    /**
     * Hak akses melihat daftar permohonan.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Hak akses melihat detail permohonan tertentu.
     */
    public function view(User $user, Submission $submission): Response
    {
        // 1. Super Admin boleh melihat semua data
        if ($user->isSuperAdmin()) {
            return Response::allow();
        }

        // 2. Admin Kecamatan hanya boleh melihat data dari kecamatan yang sama
        if ($user->isAdminKecamatan()) {
            return $user->kecamatan_id === $submission->kecamatan_id
                ? Response::allow()
                : Response::deny('Anda tidak memiliki otoritas untuk mengakses data permohonan dari kecamatan lain.');
        }

        // 3. Warga hanya boleh melihat pengajuan miliknya sendiri
        if ($user->isWarga()) {
            return $user->id === $submission->user_id
                ? Response::allow()
                : Response::deny('Anda tidak memiliki akses ke pengajuan warga lain.');
        }

        return Response::deny('Akses ditolak.');
    }

    /**
     * Hak akses membuat permohonan baru (khusus warga).
     */
    public function create(User $user): bool
    {
        return $user->isWarga();
    }

    /**
     * Hak akses mengubah/mengunggah ulang dokumen permohonan (Warga).
     * Hanya diizinkan jika status masih DRAFT atau REVISION_REQUIRED.
     */
    public function update(User $user, Submission $submission): Response
    {
        if (! $user->isWarga() || $user->id !== $submission->user_id) {
            return Response::deny('Anda tidak berhak mengubah permohonan ini.');
        }

        if (! $submission->status->isEditableByCitizen()) {
            return Response::deny("Permohonan dalam status '{$submission->status->label()}' tidak dapat diubah lagi oleh pemohon.");
        }

        return Response::allow();
    }

    /**
     * Hak akses memverifikasi / merubah status pengajuan (Admin Kecamatan).
     */
    public function review(User $user, Submission $submission): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::allow();
        }

        if ($user->isAdminKecamatan()) {
            return $user->kecamatan_id === $submission->kecamatan_id
                ? Response::allow()
                : Response::deny('Anda hanya dapat memverifikasi pengajuan di wilayah kecamatan Anda.');
        }

        return Response::deny('Hanya petugas verifikator kecamatan yang berhak melakukan verifikasi berkas.');
    }

    /**
     * Hak akses menghapus / membatalkan pengajuan (hanya saat draft oleh warga).
     */
    public function delete(User $user, Submission $submission): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::allow();
        }

        if ($user->isWarga() && $user->id === $submission->user_id && $submission->status === SubmissionStatus::Draft) {
            return Response::allow();
        }

        return Response::deny('Permohonan yang telah diproses tidak dapat dihapus.');
    }
}
