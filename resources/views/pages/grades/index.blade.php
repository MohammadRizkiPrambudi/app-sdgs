@extends('layouts.app')

@section('title', 'Nilai Tugas')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Nilai Tugas</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Filter Data</h4>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('grades.index') }}">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Kelas</label>
                                        <select name="class_id" class="form-control select2" required>
                                            <option value="">Pilih Kelas</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ $selectedClass == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Mata Pelajaran</label>
                                        <select name="subject_id" class="form-control select2" required>
                                            <option value="">Pilih Mapel</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}"
                                                    {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                                                    {{ $subject->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
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

                @if (count($assignments) > 0)
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Tugas</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Judul Tugas</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Jumlah Pengumpulan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assignments as $assignment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $assignment->title }}</td>
                                                <td>{{ $assignment->created_at->format('d M Y') }}</td>
                                                <td>{{ $assignment->submissions_count }} siswa</td>
                                                <td>
                                                    <a href="{{ route('grades.show', ['class_id' => $assignment->class_id, 'subject_id' => $assignment->subject_id]) }}"
                                                        class="btn btn-sm btn-info">
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
                @elseif(request()->filled(['class_id', 'subject_id']))
                    <div class="alert alert-warning mt-4">
                        <i class="fas fa-exclamation-circle"></i>
                        Belum ada tugas untuk kelas dan mata pelajaran yang dipilih.
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
