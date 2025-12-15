<?php

namespace App\Http\Controllers;

use App\Models\FtthOdc;
use App\Models\FtthOlt;
use App\Http\Requests\StoreFtthOdcRequest;
use App\Http\Requests\UpdateFtthOdcRequest;

class FtthOdcController extends Controller
{
    public function index()
    {
        $odcs = FtthOdc::with('olt')->orderBy('nama_odc')->paginate(10);
        return view('ftth.odc.index', compact('odcs'));
    }

    public function create()
    {
        $olts = FtthOlt::where('status', 'aktif')->orderBy('nama_olt')->get();
        return view('ftth.odc.create', compact('olts'));
    }

    public function store(StoreFtthOdcRequest $request)
    {
        FtthOdc::create($request->validated());
        return redirect()->route('ftth.odc.index')->with('success', 'ODC berhasil ditambahkan');
    }

    public function show(FtthOdc $odc)
    {
        $odc->load(['olt', 'odp']);
        return view('ftth.odc.show', compact('odc'));
    }

    public function edit(FtthOdc $odc)
    {
        $olts = FtthOlt::where('status', 'aktif')->orWhere('id', $odc->olt_id)->orderBy('nama_olt')->get();
        return view('ftth.odc.edit', compact('odc', 'olts'));
    }

    public function update(UpdateFtthOdcRequest $request, FtthOdc $odc)
    {
        $odc->update($request->validated());
        return redirect()->route('ftth.odc.index')->with('success', 'ODC berhasil diupdate');
    }

    public function destroy(FtthOdc $odc)
    {
        try {
            $odc->delete();
            return redirect()->route('ftth.odc.index')->with('success', 'ODC berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('ftth.odc.index')->with('error', 'ODC tidak bisa dihapus karena masih memiliki ODP');
        }
    }
}
