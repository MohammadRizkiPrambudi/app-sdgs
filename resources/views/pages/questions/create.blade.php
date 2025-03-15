@extends('layouts.app')

@section('title', 'Soal Ujian')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Soal Ujian</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('questions.store') }}" method="POST" id="questionForm">
                            @csrf

                            <div id="questionsContainer">
                                <div class="question-group card mb-3">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <button type="button" id="addQuestion" class="btn btn-success"> <i
                                                    class="fas fa-plus-circle"></i> Tambah
                                                Soal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Semua Soal</button>
                                        </div>
                                        <div class="form-group">
                                            <label for="exam_id">Pilih Ujian:</label>
                                            <select name="exam_id" id="exam_id" class="form-control" required>
                                                @foreach ($exams as $exam)
                                                    <option value="{{ $exam->id }}">{{ $exam->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="question_text">Pertanyaan:</label>
                                            <textarea name="questions[0][question_text]" class="form-control summernote" required></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="option_a">Opsi A:</label>
                                                    <input type="text" name="questions[0][option_a]" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="option_b">Opsi B:</label>
                                                    <input type="text" name="questions[0][option_b]" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="option_c">Opsi C:</label>
                                                    <input type="text" name="questions[0][option_c]" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="option_d">Opsi D:</label>
                                                    <input type="text" name="questions[0][option_d]" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="correct_option">Jawaban Benar:</label>
                                            <select name="questions[0][correct_option]" class="form-control" required>
                                                <option value="a">A</option>
                                                <option value="b">B</option>
                                                <option value="c">C</option>
                                                <option value="d">D</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/myscripts.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
@endpush
