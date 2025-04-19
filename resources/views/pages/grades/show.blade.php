@extends('layouts.app')

@section('title', 'Data Nilai')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Nilai Tugas</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Nilai - {{ $assignment->title }}</h4>
                        <div class="card-header-action">
                            <span class="badge badge-primary">
                                Kelas: {{ $assignment->class->name }}
                            </span>
                            <span class="badge badge-info">
                                Mapel: {{ $assignment->subject->name }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <a href="{{ route('grades.exportPdf', $assignment->id) }}" class="btn btn-danger mb-3"
                                target="_blank">
                                <i class="fas fa-print"></i> Cetak PDF
                            </a>
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Siswa</th>
                                        <th>Nilai</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        @php
                                            $submission = $submissionsMap[$student->id] ?? null;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>
                                                @if ($submission && $submission->grade !== null)
                                                    <span
                                                        class="badge badge-{{ $submission->grade >= 75 ? 'success' : 'danger' }}">
                                                        {{ $submission->grade }}
                                                    </span>
                                                @elseif ($submission)
                                                    <span class="badge badge-secondary">Belum dinilai</span>
                                                @else
                                                    <span class="badge badge-warning">Belum mengumpulkan</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($submission && $submission->grade !== null)
                                                    {{ $submission->grade >= 75 ? 'Lulus' : 'Remedial' }}
                                                @elseif ($submission)
                                                    -
                                                @else
                                                    Tidak Mengumpulkan
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('grades.index', [
                            'class_id' => $assignment->class_id,
                            'subject_id' => $assignment->subject_id,
                        ]) }}"
                            class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Tugas
                        </a>
                    </div>
                </div>
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
