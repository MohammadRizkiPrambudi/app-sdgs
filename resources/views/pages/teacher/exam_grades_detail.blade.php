@extends('layouts.app')
@section('title', 'Detail Nilai Ujian')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Nilai - {{ $exam->subject->name }}
                </h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Nilai {{ $exam->title }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('teacher.examGradesExport', $exam->id) }}" class="btn btn-success"
                                target="_blank">
                                <i class="fas fa-file-pdf"></i> Cetak PDF
                            </a>
                            <a href="{{ route('teacher.examGrades') }}" class="btn btn-danger">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <p><strong>Mata Pelajaran:</strong> {{ $exam->subject->name }}</p>
                        <p><strong>Kelas:</strong> {{ $exam->class->name }}</p>
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Benar</th>
                                    <th>Total Soal</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $result)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $result['student']->name }}</td>
                                        <td>{{ $result['correct'] }}</td>
                                        <td>{{ $result['total'] }}</td>
                                        <td>{{ $result['score'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
