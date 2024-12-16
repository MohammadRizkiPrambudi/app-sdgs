@extends('layouts.app')

@section('title', 'Daftar Tugas')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Tugas</h1>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Daftar tugas</h4>
                </div>
                <div class="card-body">
                    @if ($assignments->isEmpty())
                        <div class="alert alert-info">
                            Belum ada tugas
                        </div>
                    @else
                        <div class="list-group">
                            @foreach ($assignments as $assignment)
                                @php
                                    $submission = $submissions->where('assignment_id', $assignment->id)->first();
                                @endphp
                                <span class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Tugas {{ $assignment->subject->name }}</h5>
                                        <small>Tenggat waktu : {{ $assignment->due_date ?? 'Tidak Diketahui' }}</small>
                                    </div>
                                    <p class="mb-1">{{ $assignment->description }}</p>
                                    @if ($submission)
                                        @if ($submission->grade !== null)
                                            <p><strong>Nilai:</strong> {{ $submission->grade }}</p>
                                        @else
                                            <p class="text-danger"><strong>Status:</strong> Sudah diunggah, menunggu
                                                penilaian</p>
                                        @endif
                                    @else
                                        <a href="{{ route('submissions.create', $assignment->id) }}"
                                            class="btn btn-primary"><i class="fas fa-upload mr-1"></i>Unggah
                                            Tugas</a>
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush
