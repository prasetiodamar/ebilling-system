@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail ODP: {{ $odp->nama_odp }}</h2>
        <div>
            <a href="{{ route('ftth.odp.edit', $odp) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
            <a href="{{ route('ftth.odp.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Informasi Umum</h5></div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr><th width="40%">Nama ODP</th><td>{{ $odp->nama_odp }}</td></tr>
                        <tr><th>ODC</th><td><a href="{{ route('ftth.odc.show', $odp->odc) }}">{{ $odp->odc->nama_odc }}</a></td></tr>
                        <tr><th>Lokasi</th><td>{{ $odp->lokasi }}</td></tr>
                        <tr><th>Status</th><td><span class="badge bg-{{ $odp->status == 'aktif' ? 'success' : ($odp->status == 'maintenance' ? 'warning' : 'danger') }}">{{ ucfirst($odp->status) }}</span></td></tr>
                        <tr><th>Port Aktif</th><td>{{ $odp->jumlah_port }} ({{ $odp->port_tersedia }} tersedia)</td></tr>
                        <tr><th>Splitter</th><td>{{ $odp->splitter_ratio ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Data Tambahan</h5></div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr><th width="40%">Jenis ODP</th><td>{{ $odp->jenis_odp ?? '-' }}</td></tr>
                        <tr><th>Area Coverage</th><td>{{ $odp->area_coverage ?? '-' }}</td></tr>
                        <tr><th>Pelanggan Aktif</th><td><strong>{{ $odp->pelanggan->count() }}</strong></td></tr>
                        <tr><th>Utilisasi Port</th><td>{{ round(($odp->jumlah_port - $odp->port_tersedia) / $odp->jumlah_port * 100, 2) }}%</td></tr>
                        <tr><th>Updated</th><td>{{ $odp->updated_at->format('d/m/Y H:i') }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($odp->pelanggan->count() > 0)
        <div class="card mt-4">
            <div class="card-header"><h5 class="mb-0">Pelanggan di ODP ini</h5></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kode Pelanggan</th>
                                <th>Nama</th>
                                <th>Port ODP</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($odp->pelanggan as $pel)
                                <tr>
                                    <td><a href="{{ route('pelanggan.show', $pel) ?? '#' }}">{{ $pel->kode_pelanggan }}</a></td>
                                    <td>{{ $pel->nama }}</td>
                                    <td>{{ $pel->odp_port ?? '-' }}</td>
                                    <td><span class="badge bg-{{ $pel->status == 'aktif' ? 'success' : ($pel->status == 'suspend' ? 'warning' : 'danger') }}">{{ ucfirst($pel->status) }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
