<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFtthPopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_pop' => 'required|string|max:100',
            'lokasi' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'pic_nama' => 'nullable|string|max:100',
            'pic_telepon' => 'nullable|string|max:20',
            'alamat_lengkap' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif,maintenance',
            'keterangan' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_pop.required' => 'Nama POP wajib diisi',
            'lokasi.required' => 'Lokasi wajib diisi',
            'status.required' => 'Status wajib dipilih',
            'latitude.between' => 'Latitude harus antara -90 dan 90',
            'longitude.between' => 'Longitude harus antara -180 dan 180',
        ];
    }
}
