<?php

namespace App\Http\Requests\Submission;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRevisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        $submission = $this->route('submission');
        return $this->user()?->can('update', $submission) ?? false;
    }

    public function rules(): array
    {
        $submission = $this->route('submission');
        $rules = [
            'documents' => ['required', 'array', 'min:1'],
        ];

        if ($submission && $submission->service) {
            foreach ($submission->service->requirements as $req) {
                $formats = $req->accepted_formats ?? ['pdf', 'jpg', 'jpeg', 'png'];
                $maxKb = $req->max_size_kb ?: 5120;

                $rules["documents.{$req->id}"] = [
                    'nullable',
                    'file',
                    'mimes:' . implode(',', $formats),
                    "max:{$maxKb}",
                ];
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'documents.required' => 'Setidaknya unggah satu berkas revisi yang diminta perbaikan.',
            'documents.*.file'   => 'Berkas harus berupa file yang valid.',
            'documents.*.mimes'  => 'Format berkas revisi harus berupa :values.',
            'documents.*.max'    => 'Ukuran berkas melebihi batas maksimal :max KB.',
        ];
    }
}
