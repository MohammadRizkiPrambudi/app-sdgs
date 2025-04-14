@extends('layouts.app')

@section('title', 'Nilai Ujian')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Nilai Ujian</h1>
            </div>

            <div class="section-body">
                {{-- Filter --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Filter Data</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('teacher.examGrades') }}" method="GET">
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="class_id">Pilih Kelas</label>
                                    <select name="class_id" id="class_id" class="form-control" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->class_id }}"
                                                {{ $class_id == $class->class_id ? 'selected' : '' }}>
                                                {{ $class->class_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label for="subject_id">Pilih Mapel</label>
                                    <select name="subject_id" id="subject_id" class="form-control" required>
                                        <option value="">-- Pilih Mapel --</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->subject_id }}"
                                                {{ $subject_id == $subject->subject_id ? 'selected' : '' }}>
                                                {{ $subject->subject_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" style="padding-top: 30px">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Daftar Ujian --}}
                @if (count($exams) > 0)
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4>Daftar Ujian</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul Ujian</th>
                                            <th>Tanggal Ujian</th>
                                            <th>Jumlah Dikerjakan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($exams as $index => $exam)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $exam->title }}</td>
                                                <td>{{ \Carbon\Carbon::parse($exam->start_time)->format('d M Y H:i') }}
                                                </td>
                                                <td>{{ $exam->student_answers_count }} siswa</td>
                                                <td>
                                                    <a href="{{ route('teacher.examGradesDetail', $exam->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        Lihat Nilai
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @elseif($class_id && $subject_id)
                    <div class="alert alert-info mt-4">Tidak ada ujian ditemukan untuk kelas dan mata pelajaran ini.
                    </div>
                @endif
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
