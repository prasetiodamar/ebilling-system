@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail ODC: {{ $odc->nama_odc }}</h2>
        <div>
            <a href="{{ route('ftth.odc.edit', $odc) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
            <a href="{{ route('ftth.odc.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Informasi Umum</h5></div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr><th width="40%">Nama ODC</th><td>{{ $odc->nama_odc }}</td></tr>
                        <tr><th>OLT</th><td><a href="{{ route('ftth.olt.show', $odc->olt) }}">{{ $odc->olt->nama_olt }}</a></td></tr>
                        <tr><th>Lokasi</th><td>{{ $odc->lokasi }}</td></tr>
                        <tr><th>Status</th><td><span class="badge bg-{{ $odc->status == 'aktif' ? 'success' : ($odc->status == 'maintenance' ? 'warning' : 'danger') }}">{{ ucfirst($odc->status) }}</span></td></tr>
                        <tr><th>Port Aktif</th><td>{{ $odc->jumlah_port }} ({{ $odc->port_tersedia }} tersedia)</td></tr>
                        <tr><th>Splitter</th><td>{{ $odc->splitter_ratio ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Data Tambahan</h5></div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr><th width="40%">Jenis Kabel</th><td>{{ $odc->jenis_kabel ?? '-' }}</td></tr>
                        <tr><th>Panjang Kabel</th><td>{{ $odc->panjang_kabel ?? '-' }} m</td></tr>
                        <tr><th>Area Coverage</th><td>{{ $odc->area_coverage ?? '-' }}</td></tr>
                        <tr><th>Jumlah ODP</th><td><strong>{{ $odc->odp->count() }}</strong></td></tr>
                        <tr><th>Updated</th><td>{{ $odc->updated_at->format('d/m/Y H:i') }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
