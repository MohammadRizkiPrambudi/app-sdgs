@extends('layouts.app')

@section('title', 'Detail Materi Materi')

@push('style')
    <style>
        .video-responsive {
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
            border-radius: 10px;
            min-height: 250px;
            /* Ganti dengan tinggi minimum video */
        }

        .video-responsive iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .card {
            min-height: 350px;
            /* Ganti dengan tinggi yang sesuai */
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Mata Pelajaran {{ $material->subject->name }}</h1>
            </div>
            <div class="alert alert-info alert-has-icon">
                <div class="alert-icon"><i class="fas fa-info-circle"></i></div>
                <div class="alert-body">
                    <div class="alert-title">Info</div>
                    Tekan tombol stop suara jika tidak ingin keluar suaranya
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card rounded-box">
                            <div class="card-body">
                                <div class="card-body">
                                    @if ($material->video_url)
                                        <div class="video-responsive">
                                            <iframe id="video-frame" src="{{ $material->video_url }}" frameborder="0"
                                                allowfullscreen onerror="showFallback()"></iframe>
                                        </div>
                                        <p id="video-fallback" class="text-danger d-none">
                                            Video tidak dapat dimuat. Periksa koneksi internet Anda.
                                        </p>
                                    @else
                                        <img src="https://placehold.co/280x180?text=Video+Tidak+Tersedia&font=roboto"
                                            alt="Tidak ada video" class="img-fluid">
                                        <p class="text-muted mt-2">Tidak ada video yang disertakan untuk materi ini.</p>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card rounded-box">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>{{ $material->title }}</h4>
                                <button id="play-stop-button" onclick="toggleVoice()" class="btn btn-primary">
                                    <i id="play-stop-icon" class="fas fa-play mr-1"></i><span id="play-stop-text">Putar
                                        Suara</span>
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="material-content">
                                    {!! $chunks[$currentPage - 1] ?? '' !!}
                                </div>
                                <p id="material-content" class="d-none">{{ strip_tags($material->content) }}</p>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        @for ($i = 1; $i <= count($chunks); $i++)
                                            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                                <a class="page-link"
                                                    href="?page={{ $i }}">{{ $i }}</a>
                                            </li>
                                        @endfor
                                    </ul>
                                </nav>
                                <a href="{{ route('show.subject') }}" class="btn btn-danger">Kembali</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=auvTMQpf"></script>
    <script src="{{ asset('js/sound.js') }}"></script>
    <script>
        function showFallback() {
            document.getElementById("video-frame").style.display = "none";
            document.getElementById("video-fallback").classList.remove("d-none");
        }
    </script>
@endpush
