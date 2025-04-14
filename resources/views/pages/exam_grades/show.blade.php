@extends('layouts.app')
@section('title', 'Detail Nilai Ujian')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Nilai Ujian {{ $exam->title }}</h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-body table-responsive">
                        <a href="{{ route('grades.examExportPdf', $exam->id) }}" target="_blank" class="btn btn-danger mb-3">
                            <i class="fas fa-print"></i> Cetak PDF
                        </a>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Benar</th>
                                    <th>Total Soal</th>
                                    <th>Nilai</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $index => $student)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->correct_answers }}</td>
                                        <td>{{ $student->total_questions }}</td>
                                        <td><strong>{{ $student->score }}</strong></td>
                                        <td>
                                            @if ($student->score >= 75)
                                                <span class="badge badge-success">Lulus</span>
                                            @else
                                                <span class="badge badge-danger">Remedial</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if (count($students) === 0)
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada siswa</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
