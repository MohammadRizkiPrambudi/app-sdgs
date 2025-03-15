@extends('layouts.app')

@section('title', 'Detail Materi Materi')

@push('style')
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
                                <iframe id="video-frame" width="280" height="315"
                                    src="https://www.youtube.com/embed/jSZgKobVukk?si=Sml05nP2_XA4QjH8" frameborder="0"
                                    allowfullscreen onerror="showFallback()"></iframe>
                                <p id="video-fallback" class="text-danger d-none">Video tidak dapat dimuat. Periksa koneksi
                                    internet Anda.</p>
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
