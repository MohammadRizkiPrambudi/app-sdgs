@extends('layouts.app')

@section('title', 'Nilai Ujian')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Nilai Ujian</h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Filter Data</h4>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('grades.examIndex') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Kelas</label>
                                    <select name="class_id" class="form-control select2" required>
                                        <option value="">Pilih Kelas</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}"
                                                {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label>Mapel</label>
                                    <select name="subject_id" class="form-control select2" required>
                                        <option value="">Pilih Mapel</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}"
                                                {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2" style="margin-top: 32px">
                                    <button class="btn btn-primary btn-block">
                                        <i class="fas fa-filter mr-1"></i>Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if (count($exams))
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Ujian</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($exams as $exam)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $exam->title }}
                                    <a href="{{ route('grades.examShow', $exam->id) }}" class="btn btn-sm btn-info">Lihat
                                        Nilai</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @elseif(request()->filled(['class_id', 'subject_id']))
                <div class="alert alert-warning mt-4">
                    <i class="fas fa-exclamation-circle"></i>
                    Tidak ditemukan ujian untuk filter yang dipilih.
                </div>
            @endif
        </section>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
