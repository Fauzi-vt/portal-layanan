<?php

namespace App\Http\Requests\Submission;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDraftRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isWarga() ?? false;
    }

    public function rules(): array
    {
        $rules = [
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'documents'    => ['nullable', 'array'],
            'form_data'    => ['nullable', 'array'],
        ];

        // Validasi dinamis untuk setiap dokumen yang diunggah
        $submission = $this->route('submission');
        $service = $submission?->service;

        if ($service) {
            foreach ($service->requirements as $req) {
                $docRules = ['nullable', 'file'];

                // Format mimes (misal: pdf, jpg, jpeg, png)
                $formats = $req->accepted_formats ?? ['pdf', 'jpg', 'jpeg', 'png'];
                $docRules[] = 'mimes:' . implode(',', $formats);

                // Ukuran maksimal dalam KB (default 5120 = 5MB)
                $maxKb = $req->max_size_kb ?: 5120;
                $docRules[] = "max:{$maxKb}";

                $rules["documents.{$req->id}"] = $docRules;
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'kecamatan_id.required' => 'Kecamatan tujuan pengajuan wajib dipilih.',
            'kecamatan_id.exists'   => 'Kecamatan tidak terdaftar dalam 39 kecamatan.',
            'documents.*.mimes'     => 'Format berkas harus berupa :values.',
            'documents.*.max'       => 'Ukuran berkas melebihi batas maksimal :max KB.',
        ];
    }
}
