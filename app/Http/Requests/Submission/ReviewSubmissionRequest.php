<?php

namespace App\Http\Requests\Submission;

use Illuminate\Foundation\Http\FormRequest;

class ReviewSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        $submission = $this->route('submission');
        return $this->user()?->can('review', $submission) ?? false;
    }

    public function rules(): array
    {
        return [
            'status'                         => ['required', 'in:in_review,revision_required,processed,rejected'],
            'catatan_petugas'                => ['nullable', 'string', 'max:2000'],
            'document_reviews'               => ['nullable', 'array'],
            'document_reviews.*.status'      => ['nullable', 'in:pending,valid,invalid'],
            'document_reviews.*.note'        => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status hasil verifikasi permohonan wajib ditentukan.',
            'status.in'       => 'Pilihan status tidak valid.',
        ];
    }
}
