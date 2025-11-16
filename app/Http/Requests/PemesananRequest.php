<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PemesananRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isPencariKos();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kos_id' => 'required|exists:kos,id',
            'tanggal_masuk' => 'required|date|after_or_equal:today',
            'durasi_sewa' => 'required|integer|min:1|max:24',
            'satuan_durasi' => 'nullable|in:hari,bulan,tahun',
            'catatan' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'kos_id.required' => 'Kos wajib dipilih',
            'kos_id.exists' => 'Kos tidak valid',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi',
            'tanggal_masuk.date' => 'Tanggal masuk tidak valid',
            'tanggal_masuk.after_or_equal' => 'Tanggal masuk minimal hari ini',
            'durasi_sewa.required' => 'Durasi sewa wajib diisi',
            'durasi_sewa.integer' => 'Durasi sewa harus berupa angka',
            'durasi_sewa.min' => 'Durasi sewa minimal 1',
            'durasi_sewa.max' => 'Durasi sewa maksimal 24',
            'catatan.max' => 'Catatan maksimal 500 karakter',
        ];
    }
}
