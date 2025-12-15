@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit ODP: {{ $odp->nama_odp }}</h2>
        <a href="{{ route('ftth.odp.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('ftth.odp.update', $odp) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">ODC <span class="text-danger">*</span></label>
                            <select name="odc_id" class="form-select @error('odc_id') is-invalid @enderror" required>
                                <option value="">Pilih ODC</option>
                                @foreach($odcs as $odc)
                                    <option value="{{ $odc->id }}" {{ old('odc_id', $odp->odc_id) == $odc->id ? 'selected' : '' }}>{{ $odc->nama_odc }} ({{ $odc->olt->nama_olt }})</option>
                                @endforeach
                            </select>
                            @error('odc_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama ODP <span class="text-danger">*</span></label>
                            <input type="text" name="nama_odp" class="form-control @error('nama_odp') is-invalid @enderror" value="{{ old('nama_odp', $odp->nama_odp) }}" required>
                            @error('nama_odp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi', $odp->lokasi) }}" required>
                            @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="aktif" {{ old('status', $odp->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $odp->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                <option value="maintenance" {{ old('status', $odp->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jumlah Port <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_port" class="form-control @error('jumlah_port') is-invalid @enderror" value="{{ old('jumlah_port', $odp->jumlah_port) }}" min="0" required>
                            @error('jumlah_port')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Port Tersedia <span class="text-danger">*</span></label>
                            <input type="number" name="port_tersedia" class="form-control @error('port_tersedia') is-invalid @enderror" value="{{ old('port_tersedia', $odp->port_tersedia) }}" min="0" required>
                            @error('port_tersedia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude', $odp->latitude) }}">
                            @error('latitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude', $odp->longitude) }}">
                            @error('longitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Splitter Ratio</label>
                            <input type="text" name="splitter_ratio" class="form-control" value="{{ old('splitter_ratio', $odp->splitter_ratio) }}" placeholder="1:8">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jenis ODP</label>
                            <input type="text" name="jenis_odp" class="form-control" value="{{ old('jenis_odp', $odp->jenis_odp) }}">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $odp->keterangan) }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                    <a href="{{ route('ftth.odp.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
