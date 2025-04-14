@extends('layouts.app')

@section('title', 'Perbarui Materi')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Perbarui Materi</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card rounded-box">
                            <div class="card-body">
                                <form action="{{ route('materials.update', $material->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="class">Kelas</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $material->class->name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="subject">Mata Pelajaran</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $material->subject->name }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="title">Judul</label>
                                                <input type="text" class="form-control" id="title" name="title"
                                                    value="{{ $material->title }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="video_url">Link Video (YouTube)</label>
                                                <input type="text" class="form-control" id="video_url" name="video_url"
                                                    value="{{ old('video_url', $material->video_url ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="content">Konten</label>
                                                <textarea class="form-control summernote" id="content" name="content" rows="5" required>{{ $material->content }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fas fa-save mr-1"></i>Perbarui</button>
                                    <a href="{{ route('materials.index') }}" class="btn btn-danger"><i
                                            class="fas fa-arrow-left"></i>
                                        Batal</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
@endpush
