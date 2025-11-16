<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'nama_kos' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jenis_kos' => 'required|in:putra,putri,campur',
            'jenis_kamar' => 'required|in:kamar_mandi_dalam,kamar_mandi_luar',
            'harga' => 'required|numeric|min:0',
            'jumlah_kamar' => 'required|integer|min:1',
            'kamar_tersedia' => 'required|integer|min:0',
            'alamat' => 'required|string',
            'google_maps_link' => 'nullable|url|max:500',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'peraturan' => 'nullable|string',
            'foto_utama' => $this->isMethod('post') ? 'required|image|mimes:jpeg,jpg,png|max:2048' : 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'foto_tambahan.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'exists:fasilitas,id',
            'aktif' => 'nullable|boolean',
        ];

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama_kos.required' => 'Nama kos wajib diisi',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'jenis_kos.required' => 'Jenis kos wajib dipilih',
            'jenis_kos.in' => 'Jenis kos tidak valid',
            'jenis_kamar.required' => 'Jenis kamar wajib dipilih',
            'jenis_kamar.in' => 'Jenis kamar tidak valid',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga minimal 0',
            'jumlah_kamar.required' => 'Jumlah kamar wajib diisi',
            'jumlah_kamar.integer' => 'Jumlah kamar harus berupa angka',
            'jumlah_kamar.min' => 'Jumlah kamar minimal 1',
            'kamar_tersedia.required' => 'Kamar tersedia wajib diisi',
            'kamar_tersedia.integer' => 'Kamar tersedia harus berupa angka',
            'alamat.required' => 'Alamat wajib diisi',
            'google_maps_link.url' => 'Link Google Maps harus berupa URL yang valid',
            'google_maps_link.max' => 'Link Google Maps terlalu panjang',
            'kota.required' => 'Kota wajib diisi',
            'provinsi.required' => 'Provinsi wajib diisi',
            'foto_utama.required' => 'Foto utama wajib diupload',
            'foto_utama.image' => 'File harus berupa gambar',
            'foto_utama.mimes' => 'Format foto harus jpeg, jpg, atau png',
            'foto_utama.max' => 'Ukuran foto maksimal 2MB',
            'foto_tambahan.*.image' => 'File harus berupa gambar',
            'foto_tambahan.*.mimes' => 'Format foto harus jpeg, jpg, atau png',
            'foto_tambahan.*.max' => 'Ukuran foto maksimal 2MB',
        ];
    }
}
