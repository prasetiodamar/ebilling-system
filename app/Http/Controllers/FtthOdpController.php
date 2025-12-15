<?php

namespace App\Http\Controllers;

use App\Models\FtthOdp;
use App\Models\FtthOdc;
use App\Http\Requests\StoreFtthOdpRequest;
use App\Http\Requests\UpdateFtthOdpRequest;

class FtthOdpController extends Controller
{
    public function index()
    {
        $odps = FtthOdp::with('odc')->orderBy('nama_odp')->paginate(10);
        return view('ftth.odp.index', compact('odps'));
    }

    public function create()
    {
        $odcs = FtthOdc::where('status', 'aktif')->orderBy('nama_odc')->get();
        return view('ftth.odp.create', compact('odcs'));
    }

    public function store(StoreFtthOdpRequest $request)
    {
        FtthOdp::create($request->validated());
        return redirect()->route('ftth.odp.index')->with('success', 'ODP berhasil ditambahkan');
    }

    public function show(FtthOdp $odp)
    {
        $odp->load(['odc', 'pelanggan']);
        return view('ftth.odp.show', compact('odp'));
    }

    public function edit(FtthOdp $odp)
    {
        $odcs = FtthOdc::where('status', 'aktif')->orWhere('id', $odp->odc_id)->orderBy('nama_odc')->get();
        return view('ftth.odp.edit', compact('odp', 'odcs'));
    }

    public function update(UpdateFtthOdpRequest $request, FtthOdp $odp)
    {
        $odp->update($request->validated());
        return redirect()->route('ftth.odp.index')->with('success', 'ODP berhasil diupdate');
    }

    public function destroy(FtthOdp $odp)
    {
        try {
            $odp->delete();
            return redirect()->route('ftth.odp.index')->with('success', 'ODP berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('ftth.odp.index')->with('error', 'ODP tidak bisa dihapus karena masih memiliki pelanggan');
        }
    }
}
