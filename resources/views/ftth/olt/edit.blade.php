@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit OLT: {{ $olt->nama_olt }}</h2>
        <a href="{{ route('ftth.olt.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('ftth.olt.update', $olt) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">POP <span class="text-danger">*</span></label>
                            <select name="pop_id" class="form-select @error('pop_id') is-invalid @enderror" required>
                                <option value="">Pilih POP</option>
                                @foreach($pops as $pop)
                                    <option value="{{ $pop->id }}" {{ old('pop_id', $olt->pop_id) == $pop->id ? 'selected' : '' }}>
                                        {{ $pop->nama_pop }} - {{ $pop->lokasi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pop_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama OLT <span class="text-danger">*</span></label>
                            <input type="text" name="nama_olt" class="form-control @error('nama_olt') is-invalid @enderror"
                                   value="{{ old('nama_olt', $olt->nama_olt) }}" placeholder="Contoh: OLT-01" required>
                            @error('nama_olt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">Pilih Status</option>
                                <option value="aktif" {{ old('status', $olt->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $olt->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                <option value="maintenance" {{ old('status', $olt->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">IP Address</label>
                            <input type="text" name="ip_address" class="form-control @error('ip_address') is-invalid @enderror"
                                   value="{{ old('ip_address', $olt->ip_address) }}" placeholder="Contoh: 192.168.1.1">
                            @error('ip_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                    <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror"
                           value="{{ old('lokasi', $olt->lokasi) }}" required>
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" class="form-control @error('latitude') is-invalid @enderror"
                                   value="{{ old('latitude', $olt->latitude) }}" placeholder="Contoh: -6.200000">
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" class="form-control @error('longitude') is-invalid @enderror"
                                   value="{{ old('longitude', $olt->longitude) }}" placeholder="Contoh: 106.816666">
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Merk</label>
                            <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror"
                                   value="{{ old('merk', $olt->merk) }}" placeholder="Contoh: Huawei">
                            @error('merk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Model</label>
                            <input type="text" name="model" class="form-control @error('model') is-invalid @enderror"
                                   value="{{ old('model', $olt->model) }}" placeholder="Contoh: MA5800">
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jumlah Port PON <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_port_pon" class="form-control @error('jumlah_port_pon') is-invalid @enderror"
                                   value="{{ old('jumlah_port_pon', $olt->jumlah_port_pon) }}" min="0" required>
                            @error('jumlah_port_pon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Port Tersedia <span class="text-danger">*</span></label>
                            <input type="number" name="port_tersedia" class="form-control @error('port_tersedia') is-invalid @enderror"
                                   value="{{ old('port_tersedia', $olt->port_tersedia) }}" min="0" required>
                            @error('port_tersedia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">SNMP Community</label>
                            <input type="text" name="snmp_community" class="form-control @error('snmp_community') is-invalid @enderror"
                                   value="{{ old('snmp_community', $olt->snmp_community) }}" placeholder="Contoh: public">
                            @error('snmp_community')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">SNMP Version</label>
                            <input type="text" name="snmp_version" class="form-control @error('snmp_version') is-invalid @enderror"
                                   value="{{ old('snmp_version', $olt->snmp_version) }}" placeholder="Contoh: v2c">
                            @error('snmp_version')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                              rows="3">{{ old('keterangan', $olt->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update
                    </button>
                    <a href="{{ route('ftth.olt.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
