@extends('layouts.app')

@section('title', 'Data Materi')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Materi</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card rounded-box">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Detail Data Materi</h4>
                                <button id="play-stop-button" onclick="toggleVoice()" class="btn btn-primary">
                                    <i id="play-stop-icon" class="fas fa-play mr-1"></i><span id="play-stop-text">Putar
                                        Suara</span>
                                </button>
                            </div>
                            <div class="card-body">
                                <p class="font-weight-bold"> Mata Pelajaran : {{ $material->subject->name }} ||
                                    {{ $material->class->name }}</p>
                                <h2>{{ $material->title }}</h2>
                                <p>{!! $material->content !!}</p>
                                <p id="material-content" class="d-none">{{ strip_tags($material->content) }}</p>
                                <a href="{{ route('show.subject') }}" class="btn btn-danger"><i
                                        class="fas fa-arrow-left"></i> Kembali</a>
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
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=auvTMQpf"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/sound.js') }}"></script>
@endpush
