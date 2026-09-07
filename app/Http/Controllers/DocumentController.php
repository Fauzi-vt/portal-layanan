<?php

namespace App\Http\Controllers;

use App\Models\SubmissionDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{
    /**
     * Tampilkan pratinjau berkas persyaratan (inline) dengan otorisasi Policy.
     */
    public function show(SubmissionDocument $document): Response
    {
        $this->authorize('view', $document->submission);

        $disk = $this->resolveDisk($document->file_path);

        if (! $document->file_path || ! Storage::disk($disk)->exists($document->file_path)) {
            abort(404, 'Berkas fisik tidak ditemukan di storage server.');
        }

        $filePath = Storage::disk($disk)->path($document->file_path);
        $mimeType = $document->mime_type ?: (file_exists($filePath) ? mime_content_type($filePath) : 'application/octet-stream');

        return response()->file($filePath, [
            'Content-Type'        => $mimeType,
            'Content-Disposition' => 'inline; filename="' . addslashes($document->file_name ?: 'dokumen') . '"',
        ]);
    }

    /**
     * Unduh berkas persyaratan (attachment) dengan otorisasi Policy.
     */
    public function download(SubmissionDocument $document): Response
    {
        $this->authorize('view', $document->submission);

        $disk = $this->resolveDisk($document->file_path);

        if (! $document->file_path || ! Storage::disk($disk)->exists($document->file_path)) {
            abort(404, 'Berkas fisik tidak ditemukan di storage server.');
        }

        return Storage::disk($disk)->download(
            $document->file_path,
            $document->file_name ?: 'dokumen-persyaratan'
        );
    }

    /**
     * Tentukan disk storage tempat berkas berada (prioritas private 'local', fallback 'public').
     */
    private function resolveDisk(?string $path): string
    {
        if ($path && Storage::disk('local')->exists($path)) {
            return 'local';
        }

        return 'public';
    }
}
