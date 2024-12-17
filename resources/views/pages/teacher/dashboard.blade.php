@extends('layouts.app')

@section('title', 'Dashboard Guru')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik Rata-Rata Nilai</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="assignmentGradesChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik Pengumpulan Tugas</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="submissionProgressChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Pengumpulan Tugas</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($assignments as $assignment)
                                <h5>{{ $assignment->title }}</h5>
                                @if ($assignment->submissions->isEmpty())
                                    <div class="alert alert-info">
                                        Belum ada yang mengerjakan tugas
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table-striped table" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        #
                                                    </th>
                                                    <th>Nama Siswa</th>
                                                    <th>File Tugas</th>
                                                    <th>Nilai</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($assignment->submissions as $submission)
                                                    <tr>
                                                        <td class="text-center">{{ $no++ }}</td>
                                                        <td>{{ $submission->student->name }}</td>
                                                        <td>
                                                            <a href="{{ route('submissions.download', $submission->id) }}"
                                                                class="btn btn-primary btn-sm"><i
                                                                    class="fas fa-download mr-1"></i>Download</a>
                                                        </td>
                                                        <td>
                                                            {{ $submission->grade ?? 'Belum dinilai' }}</td>
                                                        <td>
                                                            <form action="{{ route('submissions.grade', $submission->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="number" name="grade" class="form-control"
                                                                    value="{{ $submission->grade }}" min="0"
                                                                    max="100" required> <button type="submit"
                                                                    class="btn btn-success btn-sm mt-1"><i
                                                                        class="fas fa-save mr-1"></i>Simpan
                                                                    Nilai</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var assignmentTitles = @json($assignments->pluck('title'));
            var assignmentGrades = @json($assignmentGrades);
            var submissionProgress = @json($submissionProgress);
            var ctx1 = document.getElementById('assignmentGradesChart').getContext('2d');
            var assignmentGradesChart = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: assignmentTitles,
                    datasets: [{
                        label: 'Rata-rata Nilai',
                        data: assignmentGrades,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var ctx2 = document.getElementById('submissionProgressChart').getContext('2d');
            var labels = submissionProgress.map((_, index) => 'Tugas ' + (index + 1));
            var data = submissionProgress.map(progress => progress.submitted);
            var dataNotSubmitted = submissionProgress.map(progress => progress.not_submitted);
            var submissionProgressChart = new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: ['Sudah Mengumpulkan', 'Belum Mengumpulkan'],
                    datasets: [{
                        data: [data.reduce((a, b) => a + b, 0), dataNotSubmitted.reduce((a, b) =>
                            a + b, 0
                        )],
                        backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(255, 99, 132, 0.6)'],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Progres Pengumpulan Tugas'
                        }
                    }
                }
            });
        });
    </script>
@endpush
