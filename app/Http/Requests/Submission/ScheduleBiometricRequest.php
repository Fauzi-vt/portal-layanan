<?php

namespace App\Http\Requests\Submission;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleBiometricRequest extends FormRequest
{
    public function authorize(): bool
    {
        $submission = $this->route('submission');
        return $this->user()?->can('review', $submission) ?? false;
    }

    public function rules(): array
    {
        return [
            'jadwal_biometrik' => ['required', 'date', 'after:now'],
            'nomor_antrean'    => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'jadwal_biometrik.required' => 'Waktu jadwal perekaman biometrik e-KTP wajib diisi.',
            'jadwal_biometrik.after'    => 'Waktu jadwal biometrik harus di masa mendatang.',
        ];
    }
}
