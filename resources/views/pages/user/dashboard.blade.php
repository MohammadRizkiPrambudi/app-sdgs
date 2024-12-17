@extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="row d-flex flex-wrap justify-content-between custom-row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-10">
                    <div class="card card-statistic-1 bg-card-1">
                        <div class="card-icon bg-card-mini-green">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 style="font-weight: bold; color: black; white-space: nowrap;">Total Siswa</h4>
                            </div>
                            <div class="card-body mt-2">
                                {{ $total_students }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-10">
                    <div class="card card-statistic-1 bg-card-2">
                        <div class="card-icon bg-card-mini-purple">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 style="font-weight: bold; color: black; white-space: nowrap;">Data Mapel</h4>
                            </div>
                            <div class="card-body mt-2">
                                {{ $total_subjects }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-10">
                    <div class="card card-statistic-1 bg-card-3">
                        <div class="card-icon bg-card-mini-orange">
                            <i class="fa-solid fa-chalkboard-user fa-lg" style="color: #ffffff;"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 style="font-weight: bold; color: black; white-space: nowrap;">Total Guru</h4>
                            </div>
                            <div class="card-body mt-2">
                                {{ $total_teachers }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-10">
                    <div class="card card-statistic-1 bg-card-4">
                        <div class="card-icon bg-card-mini-blue">
                            <i class="fas fa-school fa-lg" style="color: #ffffff;"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 style="font-weight: bold; color: black; white-space: nowrap;">Total Kelas</h4>
                            </div>
                            <div class="card-body mt-2">
                                {{ $total_classes }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-10">
                    <div class="card card-statistic-1 bg-card-5">
                        <div class="card-icon" style="background-color: #8D0B41">
                            <i class="fas fa-school fa-lg" style="color: #ffffff;"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 style="font-weight: bold; color: black; white-space: nowrap;">Total Materi</h4>
                            </div>
                            <div class="card-body mt-2">
                                {{ $total_materi }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="assignmentGradesChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="submissionProgressChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="gradeDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="subjectGradesChart"></canvas>
                        </div>
                    </div>
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

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var assignmentTitles = @json($assignments->pluck('title'));
            var assignmentGrades = @json($assignmentGrades);
            var submissionProgress = @json($submissionProgress);
            var gradeDistribution = @json($gradeDistribution);
            var subjectNames = @json($subjects->pluck('name'));
            var subjectGrades = @json($subjectGrades);


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
            var submissionProgressChart = new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: ['Sudah Mengumpulkan', 'Belum Mengumpulkan'],
                    datasets: [{
                        data: [submissionProgress.reduce((acc, curr) => acc + curr.submitted, 0),
                            submissionProgress.reduce((acc, curr) => acc + curr.not_submitted,
                                0)
                        ],
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

            var ctx3 = document.getElementById('gradeDistributionChart').getContext('2d');
            var gradeDistributionChart = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: Object.keys(gradeDistribution.flat().reduce((acc, curr) => {
                        Object.keys(curr).forEach(key => acc[key] = true);
                        return acc;
                    }, {})),
                    datasets: [{
                        label: 'Distribusi Nilai',
                        data: Object.values(gradeDistribution.flat().reduce((acc, curr) => {
                            Object.keys(curr).forEach(key => acc[key] = (acc[key] ||
                                0) + curr[key]);
                            return acc;
                        }, {})),
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

            var ctx4 = document.getElementById('subjectGradesChart').getContext('2d');
            var subjectGradesChart = new Chart(ctx4, {
                type: 'bar',
                data: {
                    labels: subjectNames,
                    datasets: [{
                        label: 'Nilai Rata-rata',
                        data: subjectGrades,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
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
