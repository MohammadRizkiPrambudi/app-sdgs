@extends('layouts.app')

@section('title', 'Data Peserta Didik')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Peserta Didik</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card rounded-box">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Daftar Peserta Didik Perkelas</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group">
                                    @foreach ($students as $student)
                                        <li class="list-group-item">{{ $student->name }}</li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('show.class') }}" class="btn btn-danger mt-2"><i
                                        class="fas fa-arrow-left mr-1"></i>Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <!-- Page Specific JS File -->
@endpush
