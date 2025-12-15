@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Management ODC (Optical Distribution Cabinet)</h2>
        <a href="{{ route('ftth.odc.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah ODC
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
                            <th>Nama ODC</th>
                            <th>OLT</th>
                            <th>Lokasi</th>
                            <th>Port</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($odcs as $odc)
                            <tr>
                                <td>{{ $odc->nama_odc }}</td>
                                <td><a href="{{ route('ftth.olt.show', $odc->olt) }}">{{ $odc->olt->nama_olt }}</a></td>
                                <td>{{ $odc->lokasi }}</td>
                                <td><span class="badge bg-info">{{ $odc->jumlah_port }} ({{ $odc->port_tersedia }} tersedia)</span></td>
                                <td>
                                    @if($odc->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($odc->status == 'maintenance')
                                        <span class="badge bg-warning">Maintenance</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('ftth.odc.show', $odc) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('ftth.odc.edit', $odc) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('ftth.odc.destroy', $odc) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center">Belum ada data ODC</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $odcs->links() }}</div>
        </div>
    </div>
</div>
@endsection
