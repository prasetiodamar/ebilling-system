@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Management POP (Point of Presence)</h2>
        <a href="{{ route('ftth.pop.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah POP
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
                            <th>Nama POP</th>
                            <th>Lokasi</th>
                            <th>PIC</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pops as $pop)
                            <tr>
                                <td>{{ $pop->nama_pop }}</td>
                                <td>{{ $pop->lokasi }}</td>
                                <td>{{ $pop->pic_nama ?? '-' }}</td>
                                <td>{{ $pop->pic_telepon ?? '-' }}</td>
                                <td>
                                    @if($pop->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($pop->status == 'maintenance')
                                        <span class="badge bg-warning">Maintenance</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('ftth.pop.show', $pop) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('ftth.pop.edit', $pop) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('ftth.pop.destroy', $pop) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus POP ini?')">
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
                                <td colspan="6" class="text-center">Belum ada data POP</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pops->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
