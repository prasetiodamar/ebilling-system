<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Show pelanggan list
     */
    public function index()
    {
        // Mock data - nanti akan diganti dengan database query
        $pelanggans = [
            [
                'id' => 1,
                'nama' => 'PT Maju Jaya',
                'alamat' => 'Jl. Sudirman No. 123, Jakarta',
                'telepon' => '021-1234567',
                'email' => 'info@majujaya.com',
                'status' => 'aktif',
                'tipe_paket' => 'Premium',
            ],
            [
                'id' => 2,
                'nama' => 'CV Sukses Mandiri',
                'alamat' => 'Jl. Gatot Subroto No. 456, Jakarta',
                'telepon' => '021-7654321',
                'email' => 'admin@sukses.com',
                'status' => 'aktif',
                'tipe_paket' => 'Standard',
            ],
            [
                'id' => 3,
                'nama' => 'Toko Elektronik Budi',
                'alamat' => 'Jl. Ahmad Yani No. 789, Bandung',
                'telepon' => '0274-5555555',
                'email' => 'budi@toko.com',
                'status' => 'suspend',
                'tipe_paket' => 'Basic',
            ],
        ];

        return view('pelanggan.index', ['pelanggans' => $pelanggans]);
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('pelanggan.create');
    }

    /**
     * Store pelanggan
     */
    public function store(Request $request)
    {
        // Validate
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'email' => 'required|email',
            'tipe_paket' => 'required|string',
        ]);

        // For now, just redirect back
        // Later akan disimpan ke database
        return redirect('/pelanggan')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        // Mock data
        $pelanggan = [
            'id' => $id,
            'nama' => 'PT Maju Jaya',
            'alamat' => 'Jl. Sudirman No. 123, Jakarta',
            'telepon' => '021-1234567',
            'email' => 'info@majujaya.com',
            'tipe_paket' => 'Premium',
        ];

        return view('pelanggan.edit', ['pelanggan' => $pelanggan]);
    }

    /**
     * Update pelanggan
     */
    public function update(Request $request, $id)
    {
        // Validate
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'email' => 'required|email',
            'tipe_paket' => 'required|string',
        ]);

        // For now, just redirect back
        // Later akan di-update di database
        return redirect('/pelanggan')->with('success', 'Pelanggan berhasil diupdate');
    }

    /**
     * Delete pelanggan
     */
    public function destroy($id)
    {
        // For now, just redirect back
        // Later akan dihapus dari database
        return redirect('/pelanggan')->with('success', 'Pelanggan berhasil dihapus');
    }
}
