@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Management ODP (Optical Distribution Point)</h2>
        <a href="{{ route('ftth.odp.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah ODP
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama ODP</th>
                            <th>ODC</th>
                            <th>Lokasi</th>
                            <th>Port</th>
                            <th>Pelanggan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($odps as $odp)
                            <tr>
                                <td>{{ $odp->nama_odp }}</td>
                                <td><a href="{{ route('ftth.odc.show', $odp->odc) }}">{{ $odp->odc->nama_odc }}</a></td>
                                <td>{{ $odp->lokasi }}</td>
                                <td><span class="badge bg-info">{{ $odp->jumlah_port }} ({{ $odp->port_tersedia }} tersedia)</span></td>
                                <td><span class="badge bg-primary">{{ $odp->pelanggan->count() }}</span></td>
                                <td>
                                    @if($odp->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($odp->status == 'maintenance')
                                        <span class="badge bg-warning">Maintenance</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('ftth.odp.show', $odp) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('ftth.odp.edit', $odp) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('ftth.odp.destroy', $odp) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center">Belum ada data ODP</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $odps->links() }}</div>
        </div>
    </div>
</div>
@endsection
