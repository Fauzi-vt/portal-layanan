<?php

namespace App\Http\Requests\Submission;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isWarga() ?? false;
    }

    public function rules(): array
    {
        $rules = [
            'service_id'   => ['required', 'exists:services,id'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'submit_now'   => ['nullable', 'boolean'],
            'documents'    => ['nullable', 'array'],
            'form_data'    => ['nullable', 'array'],
        ];

        // Validasi dinamis untuk setiap dokumen yang diunggah
        if ($this->has('service_id')) {
            $service = Service::with('requirements')->find($this->input('service_id'));

            if ($service) {
                foreach ($service->requirements as $req) {
                    $docRules = [];

                    // Jika langsung submit dan requirement wajib
                    if ($this->boolean('submit_now') && $req->is_required) {
                        $docRules[] = 'required';
                    } else {
                        $docRules[] = 'nullable';
                    }

                    $docRules[] = 'file';

                    // Format mimes (misal: pdf, jpg, jpeg, png)
                    $formats = $req->accepted_formats ?? ['pdf', 'jpg', 'jpeg', 'png'];
                    $docRules[] = 'mimes:' . implode(',', $formats);

                    // Ukuran maksimal dalam KB (default 5120 = 5MB)
                    $maxKb = $req->max_size_kb ?: 5120;
                    $docRules[] = "max:{$maxKb}";

                    $rules["documents.{$req->id}"] = $docRules;
                }
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'service_id.required'   => 'Jenis layanan wajib dipilih.',
            'service_id.exists'     => 'Layanan yang dipilih tidak valid.',
            'kecamatan_id.required' => 'Kecamatan tujuan pengajuan wajib dipilih.',
            'kecamatan_id.exists'   => 'Kecamatan tidak terdaftar dalam 39 kecamatan.',
            'documents.*.required'  => 'Dokumen persyaratan wajib diunggah.',
            'documents.*.mimes'     => 'Format berkas harus berupa :values.',
            'documents.*.max'       => 'Ukuran berkas melebihi batas maksimal :max KB.',
        ];
    }
}
