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
                                100{{-- {{ $total_materi }} --}}
                            </div>
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
@endpush
