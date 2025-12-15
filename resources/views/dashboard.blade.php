@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-1">Selamat Datang, {{ $username }}!</h2>
            <p class="text-muted">Berikut adalah ringkasan sistem E-Billing Anda</p>
        </div>
    </div>

    <div class="row g-4">
        @foreach($stats as $stat)
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">{{ $stat['title'] }}</p>
                            <h3 class="mb-0 fw-bold">{{ $stat['value'] }}</h3>
                        </div>
                        <div class="bg-{{ $stat['color'] }} bg-opacity-10 p-3 rounded">
                            <i class="bi bi-{{ $stat['icon'] }} fs-4 text-{{ $stat['color'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="bi bi-graph-up text-primary me-2"></i>Aktivitas Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Sistem E-Billing berhasil dijalankan! Role Anda: <strong>{{ ucfirst($role) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush
