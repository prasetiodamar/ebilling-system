@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail OLT: {{ $olt->nama_olt }}</h2>
        <div>
            <a href="{{ route('ftth.olt.edit', $olt) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('ftth.olt.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Umum</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Nama OLT</th>
                            <td>{{ $olt->nama_olt }}</td>
                        </tr>
                        <tr>
                            <th>POP</th>
                            <td>
                                <a href="{{ route('ftth.pop.show', $olt->pop) }}" class="text-decoration-none">
                                    {{ $olt->pop->nama_pop }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $olt->lokasi }}</td>
                        </tr>
                        <tr>
                            <th>Koordinat</th>
                            <td>
                                @if($olt->latitude && $olt->longitude)
                                    {{ $olt->latitude }}, {{ $olt->longitude }}
                                    <br>
                                    <a href="https://www.google.com/maps?q={{ $olt->latitude }},{{ $olt->longitude }}"
                                       target="_blank" class="btn btn-sm btn-info mt-2">
                                        <i class="bi bi-geo-alt"></i> Lihat di Google Maps
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($olt->status == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($olt->status == 'maintenance')
                                    <span class="badge bg-warning">Maintenance</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $olt->keterangan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Hardware Specification</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Merk</th>
                            <td>{{ $olt->merk ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Model</th>
                            <td>{{ $olt->model ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>IP Address</th>
                            <td>
                                @if($olt->ip_address)
                                    <code>{{ $olt->ip_address }}</code>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Port Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Total Port PON</th>
                            <td><strong>{{ $olt->jumlah_port_pon }}</strong> port</td>
                        </tr>
                        <tr>
                            <th>Port Tersedia</th>
                            <td>
                                <span class="badge bg-success">{{ $olt->port_tersedia }} port</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Port Terpakai</th>
                            <td>
                                <strong>{{ $olt->jumlah_port_pon - $olt->port_tersedia }}</strong> port
                                @if($olt->jumlah_port_pon > 0)
                                    <div class="progress mt-2">
                                        <div class="progress-bar bg-danger" role="progressbar"
                                             style="width: {{ (($olt->jumlah_port_pon - $olt->port_tersedia) / $olt->jumlah_port_pon * 100) }}%">
                                            {{ round(($olt->jumlah_port_pon - $olt->port_tersedia) / $olt->jumlah_port_pon * 100) }}%
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Utilisasi</th>
                            <td>
                                @if($olt->jumlah_port_pon > 0)
                                    {{ round(($olt->jumlah_port_pon - $olt->port_tersedia) / $olt->jumlah_port_pon * 100, 2) }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">SNMP Configuration</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Community</th>
                            <td>{{ $olt->snmp_community ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Version</th>
                            <td>{{ $olt->snmp_version ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statistik</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Jumlah ODC</th>
                            <td><strong>{{ $olt->odc->count() }}</strong> unit</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $olt->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Update</th>
                            <td>{{ $olt->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($olt->odc->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Daftar ODC di OLT ini</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama ODC</th>
                                <th>Lokasi</th>
                                <th>Port</th>
                                <th>Splitter</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($olt->odc as $odc)
                                <tr>
                                    <td>{{ $odc->nama_odc }}</td>
                                    <td>{{ $odc->lokasi }}</td>
                                    <td>{{ $odc->jumlah_port }} port ({{ $odc->port_tersedia }} tersedia)</td>
                                    <td>{{ $odc->splitter_ratio ?? '-' }}</td>
                                    <td>
                                        @if($odc->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif($odc->status == 'maintenance')
                                            <span class="badge bg-warning">Maintenance</span>
                                        @else
                                            <span class="badge bg-danger">Nonaktif</span>
                                        @endif
                                    </td>
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
