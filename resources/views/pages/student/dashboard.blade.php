@extends('layouts.app')

@section('title', 'General Dashboard')

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
            @if (session('error'))
                <div class="alert alert-danger"> {{ session('error') }} </div>
            @endif
            <div class="row">
                @foreach ($subjects as $subject)
                    <div class="col-lg-4 col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $subject->name }}</h5>
                                <p class="card-text">{{ $subject->description }}</p>
                                <p class="card-text">Nama Guru : {{ $teacher->name }}</p>
                                <a href="#" class="btn btn-primary">Lihat Materi</a>
                            </div>
                        </div>
                    </div>
                @endforeach
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
