<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFtthOdcRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'olt_id' => 'required|exists:ftth_olt,id',
            'nama_odc' => 'required|string|max:100',
            'olt_port' => 'nullable|string|max:50',
            'lokasi' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'jumlah_port' => 'required|integer|min:0',
            'port_tersedia' => 'required|integer|min:0',
            'splitter_ratio' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,nonaktif,maintenance',
            'jenis_kabel' => 'nullable|string|max:50',
            'panjang_kabel' => 'nullable|numeric|min:0',
            'area_coverage' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'olt_id.required' => 'OLT wajib dipilih',
            'nama_odc.required' => 'Nama ODC wajib diisi',
            'lokasi.required' => 'Lokasi wajib diisi',
            'jumlah_port.required' => 'Jumlah port wajib diisi',
            'status.required' => 'Status wajib dipilih',
        ];
    }
}
