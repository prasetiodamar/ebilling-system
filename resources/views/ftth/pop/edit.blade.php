@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit POP: {{ $pop->nama_pop }}</h2>
        <a href="{{ route('ftth.pop.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('ftth.pop.update', $pop) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama POP <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pop" class="form-control @error('nama_pop') is-invalid @enderror"
                                   value="{{ old('nama_pop', $pop->nama_pop) }}" required>
                            @error('nama_pop')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">Pilih Status</option>
                                <option value="aktif" {{ old('status', $pop->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $pop->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                <option value="maintenance" {{ old('status', $pop->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                    <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror"
                           value="{{ old('lokasi', $pop->lokasi) }}" required>
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" class="form-control @error('latitude') is-invalid @enderror"
                                   value="{{ old('latitude', $pop->latitude) }}" placeholder="Contoh: -6.200000">
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" class="form-control @error('longitude') is-invalid @enderror"
                                   value="{{ old('longitude', $pop->longitude) }}" placeholder="Contoh: 106.816666">
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" class="form-control @error('alamat_lengkap') is-invalid @enderror"
                              rows="3">{{ old('alamat_lengkap', $pop->alamat_lengkap) }}</textarea>
                    @error('alamat_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama PIC</label>
                            <input type="text" name="pic_nama" class="form-control @error('pic_nama') is-invalid @enderror"
                                   value="{{ old('pic_nama', $pop->pic_nama) }}">
                            @error('pic_nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Telepon PIC</label>
                            <input type="text" name="pic_telepon" class="form-control @error('pic_telepon') is-invalid @enderror"
                                   value="{{ old('pic_telepon', $pop->pic_telepon) }}">
                            @error('pic_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                              rows="3">{{ old('keterangan', $pop->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update
                    </button>
                    <a href="{{ route('ftth.pop.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
