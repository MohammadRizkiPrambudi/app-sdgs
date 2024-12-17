@extends('layouts.app')

@section('title', 'Dashboard Siswa')

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
                <div class="row">
                    <div class="col-12">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="col-12">
                        <p style="color: #6777ef; font-size: larger">Hallo Selamat Datang {{ $user->name }} 😁</p>
                    </div>
                </div>
            </div>

            <div class="row">
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
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik Rata-rata Nilai</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="subjectGradesChart"></canvas>
                        </div>
                    </div>
                </div>
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
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var subjectNames = @json($subjects->pluck('name'));
            var subjectGrades = @json($subjectGrades);
            var submissionProgress = @json($submissionProgress);

            var ctx1 = document.getElementById('submissionProgressChart').getContext('2d');
            var submissionProgressChart = new Chart(ctx1, {
                type: 'pie',
                data: {
                    labels: ['Sudah Mengumpulkan', 'Belum Mengumpulkan'],
                    datasets: [{
                        data: [submissionProgress.submitted, submissionProgress.not_submitted],
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

            var ctx2 = document.getElementById('subjectGradesChart').getContext('2d');
            var subjectGradesChart = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: subjectNames,
                    datasets: [{
                        label: 'Nilai Rata-rata',
                        data: subjectGrades,
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
        });
    </script>
@endpush
