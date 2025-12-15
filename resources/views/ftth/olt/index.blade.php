@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Management OLT (Optical Line Terminal)</h2>
        <a href="{{ route('ftth.olt.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah OLT
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama OLT</th>
                            <th>POP</th>
                            <th>IP Address</th>
                            <th>Lokasi</th>
                            <th>Merk/Model</th>
                            <th>Port PON</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($olts as $olt)
                            <tr>
                                <td>{{ $olt->nama_olt }}</td>
                                <td>
                                    <a href="{{ route('ftth.pop.show', $olt->pop) }}" class="text-decoration-none">
                                        {{ $olt->pop->nama_pop }}
                                    </a>
                                </td>
                                <td>{{ $olt->ip_address ?? '-' }}</td>
                                <td>{{ $olt->lokasi }}</td>
                                <td>{{ $olt->merk }} {{ $olt->model }}</td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $olt->jumlah_port_pon }} port
                                    </span>
                                    <span class="badge bg-success">
                                        {{ $olt->port_tersedia }} tersedia
                                    </span>
                                </td>
                                <td>
                                    @if($olt->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($olt->status == 'maintenance')
                                        <span class="badge bg-warning">Maintenance</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('ftth.olt.show', $olt) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('ftth.olt.edit', $olt) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('ftth.olt.destroy', $olt) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus OLT ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data OLT</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $olts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
