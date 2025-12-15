<?php

namespace App\Http\Controllers;

use App\Models\FtthPop;
use App\Http\Requests\StoreFtthPopRequest;
use App\Http\Requests\UpdateFtthPopRequest;
use Illuminate\Http\Request;

class FtthPopController extends Controller
{
    public function index()
    {
        $pops = FtthPop::orderBy('nama_pop')->paginate(10);
        return view('ftth.pop.index', compact('pops'));
    }

    public function create()
    {
        return view('ftth.pop.create');
    }

    public function store(StoreFtthPopRequest $request)
    {
        FtthPop::create($request->validated());

        return redirect()
            ->route('ftth.pop.index')
            ->with('success', 'POP berhasil ditambahkan');
    }

    public function show(FtthPop $pop)
    {
        $pop->load(['olt']);
        return view('ftth.pop.show', compact('pop'));
    }

    public function edit(FtthPop $pop)
    {
        return view('ftth.pop.edit', compact('pop'));
    }

    public function update(UpdateFtthPopRequest $request, FtthPop $pop)
    {
        $pop->update($request->validated());

        return redirect()
            ->route('ftth.pop.index')
            ->with('success', 'POP berhasil diupdate');
    }

    public function destroy(FtthPop $pop)
    {
        try {
            $pop->delete();
            return redirect()
                ->route('ftth.pop.index')
                ->with('success', 'POP berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->route('ftth.pop.index')
                ->with('error', 'POP tidak bisa dihapus karena masih memiliki OLT');
        }
    }
}
