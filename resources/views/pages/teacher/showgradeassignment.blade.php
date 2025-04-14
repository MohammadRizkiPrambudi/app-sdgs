@extends('layouts.app')

@section('title', 'Detail Nilai Tugas')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Nilai Tugas {{ $assignment->subject->name }}</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $assignment->title }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('teacher.gradesAssignmentExport', $assignment->id) }}" class="btn btn-success"
                                target="_blank">
                                <i class="fas fa-file-pdf"></i> Cetak PDF
                            </a>
                            <a href="{{ route('teacher.grades') }}" class="btn btn-danger">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <p><strong>Kelas:</strong> {{ $assignment->class->name }}</p>
                        <p><strong>Deskripsi:</strong> {{ $assignment->description }}</p>

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Siswa</th>
                                        <th class="text-center">Nilai</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($students->count() > 0)
                                        @foreach ($students as $index => $student)
                                            @php
                                                $submission = $assignment->submissions->firstWhere(
                                                    'student_id',
                                                    $student->id,
                                                );
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-center">{{ $student->user->name }}</td>
                                                <td class="text-center">{{ $submission->grade ?? '-' }}</td>
                                                <td>
                                                    @if (!is_null($submission?->grade))
                                                        @if ($submission->grade >= 70)
                                                            <span class="badge badge-success">Lulus</span>
                                                        @else
                                                            <span class="badge badge-danger">Tidak Lulus</span>
                                                        @endif
                                                    @else
                                                        <span class="badge badge-warning">Belum Dinilai</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Tidak ada data siswa untuk
                                                kelas ini.</td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                        </div>

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
