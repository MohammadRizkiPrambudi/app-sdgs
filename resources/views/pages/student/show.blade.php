@extends('layouts.app')

@section('title', 'Data Peserta Didik')

@push('style')
    <style>
        .list-group-item:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease-in-out;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Peserta Didik</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                                <h4 class="mb-0 text-light">Daftar Peserta Didik Perkelas</h4>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">Berikut adalah daftar peserta didik yang terdaftar dalam kelas ini.
                                </p>
                                <ul class="list-group">
                                    @foreach ($students as $index => $s)
                                        <li
                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $s->avatar ? asset('storage/avatars/' . $s->avatar) : asset('img/avatar/avatar-1.png') }}"
                                                    class="rounded-circle mr-2" width="35">
                                                <span>{{ $s->name }}</span>
                                            </div>
                                            <span class="badge badge-success badge-pill">✔ Siswa</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
