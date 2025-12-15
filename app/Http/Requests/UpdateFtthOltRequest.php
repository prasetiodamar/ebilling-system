<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFtthOltRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pop_id' => 'required|exists:ftth_pop,id',
            'nama_olt' => 'required|string|max:100',
            'ip_address' => 'nullable|ip',
            'lokasi' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'merk' => 'nullable|string|max:50',
            'model' => 'nullable|string|max:50',
            'jumlah_port_pon' => 'required|integer|min:0',
            'port_tersedia' => 'required|integer|min:0',
            'status' => 'required|in:aktif,nonaktif,maintenance',
            'snmp_community' => 'nullable|string|max:50',
            'snmp_version' => 'nullable|string|max:10',
            'keterangan' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'pop_id.required' => 'POP wajib dipilih',
            'pop_id.exists' => 'POP tidak valid',
            'nama_olt.required' => 'Nama OLT wajib diisi',
            'lokasi.required' => 'Lokasi wajib diisi',
            'ip_address.ip' => 'Format IP Address tidak valid',
            'jumlah_port_pon.required' => 'Jumlah port PON wajib diisi',
            'jumlah_port_pon.min' => 'Jumlah port PON minimal 0',
            'port_tersedia.required' => 'Port tersedia wajib diisi',
            'port_tersedia.min' => 'Port tersedia minimal 0',
            'status.required' => 'Status wajib dipilih',
            'latitude.between' => 'Latitude harus antara -90 dan 90',
            'longitude.between' => 'Longitude harus antara -180 dan 180',
        ];
    }
}
