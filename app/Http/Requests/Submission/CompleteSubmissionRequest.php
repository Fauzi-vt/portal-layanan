<?php

namespace App\Http\Requests\Submission;

use Illuminate\Foundation\Http\FormRequest;

class CompleteSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        $submission = $this->route('submission');
        return $this->user()?->can('review', $submission) ?? false;
    }

    public function rules(): array
    {
        return [
            'output_file'      => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'completion_notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'output_file.mimes' => 'Format file e-dokumen harus berupa PDF, JPG, atau PNG.',
            'output_file.max'   => 'Ukuran file e-dokumen maksimal 10 MB.',
        ];
    }
}
