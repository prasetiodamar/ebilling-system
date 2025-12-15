@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail POP: {{ $pop->nama_pop }}</h2>
        <div>
            <a href="{{ route('ftth.pop.edit', $pop) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('ftth.pop.index') }}" class="btn btn-secondary">
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
                            <th width="40%">Nama POP</th>
                            <td>{{ $pop->nama_pop }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $pop->lokasi }}</td>
                        </tr>
                        <tr>
                            <th>Alamat Lengkap</th>
                            <td>{{ $pop->alamat_lengkap ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Koordinat</th>
                            <td>
                                @if($pop->latitude && $pop->longitude)
                                    {{ $pop->latitude }}, {{ $pop->longitude }}
                                    <br>
                                    <a href="https://www.google.com/maps?q={{ $pop->latitude }},{{ $pop->longitude }}"
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
                                @if($pop->status == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($pop->status == 'maintenance')
                                    <span class="badge bg-warning">Maintenance</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $pop->keterangan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Person In Charge (PIC)</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Nama PIC</th>
                            <td>{{ $pop->pic_nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>
                                @if($pop->pic_telepon)
                                    {{ $pop->pic_telepon }}
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pop->pic_telepon) }}"
                                       target="_blank" class="btn btn-sm btn-success ms-2">
                                        <i class="bi bi-whatsapp"></i> WhatsApp
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statistik</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Jumlah OLT</th>
                            <td><strong>{{ $pop->olt->count() }}</strong> unit</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $pop->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Update</th>
                            <td>{{ $pop->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($pop->olt->count() > 0)
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Daftar OLT di POP ini</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama OLT</th>
                                <th>IP Address</th>
                                <th>Merk/Model</th>
                                <th>Port PON</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pop->olt as $olt)
                                <tr>
                                    <td>{{ $olt->nama_olt }}</td>
                                    <td>{{ $olt->ip_address ?? '-' }}</td>
                                    <td>{{ $olt->merk }} {{ $olt->model }}</td>
                                    <td>{{ $olt->jumlah_port_pon }} port ({{ $olt->port_tersedia }} tersedia)</td>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
