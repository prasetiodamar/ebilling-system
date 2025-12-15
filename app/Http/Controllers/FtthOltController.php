<?php

namespace App\Http\Controllers;

use App\Models\FtthOlt;
use App\Models\FtthPop;
use App\Http\Requests\StoreFtthOltRequest;
use App\Http\Requests\UpdateFtthOltRequest;
use Illuminate\Http\Request;

class FtthOltController extends Controller
{
    public function index()
    {
        $olts = FtthOlt::with('pop')->orderBy('nama_olt')->paginate(10);
        return view('ftth.olt.index', compact('olts'));
    }

    public function create()
    {
        $pops = FtthPop::where('status', 'aktif')->orderBy('nama_pop')->get();
        return view('ftth.olt.create', compact('pops'));
    }

    public function store(StoreFtthOltRequest $request)
    {
        FtthOlt::create($request->validated());

        return redirect()
            ->route('ftth.olt.index')
            ->with('success', 'OLT berhasil ditambahkan');
    }

    public function show(FtthOlt $olt)
    {
        $olt->load(['pop', 'odc']);
        return view('ftth.olt.show', compact('olt'));
    }

    public function edit(FtthOlt $olt)
    {
        $pops = FtthPop::where('status', 'aktif')
                       ->orWhere('id', $olt->pop_id)
                       ->orderBy('nama_pop')
                       ->get();
        return view('ftth.olt.edit', compact('olt', 'pops'));
    }

    public function update(UpdateFtthOltRequest $request, FtthOlt $olt)
    {
        $olt->update($request->validated());

        return redirect()
            ->route('ftth.olt.index')
            ->with('success', 'OLT berhasil diupdate');
    }

    public function destroy(FtthOlt $olt)
    {
        try {
            $olt->delete();
            return redirect()
                ->route('ftth.olt.index')
                ->with('success', 'OLT berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->route('ftth.olt.index')
                ->with('error', 'OLT tidak bisa dihapus karena masih memiliki ODC');
        }
    }
}
