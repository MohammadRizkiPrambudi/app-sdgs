@extends('layouts.app')

@section('title', 'Soal Ujian')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Soal Ujian</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('questions.create') }}" class="btn btn-primary mb-3"><i
                                        class="fas fa-plus-circle"></i> Tambah
                                    Soal</a>
                                <button type="button" class="btn btn-success mb-3" data-toggle="modal"
                                    data-target="#importModal">
                                    <i class="fas fa-file-excel"></i> Import Soal
                                </button>
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th class="text-center">Nama Ujian</th>
                                                <th class="text-center">Kelas</th>
                                                <th class="text-center">Mapel</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($exams as $index => $exam)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td class="text-center">{{ $exam->title }}</td>
                                                    <td class="text-center">{{ $exam->class->name }}</td>
                                                    <td class="text-center">{{ $exam->subject->name }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info" data-toggle="modal"
                                                            data-target="#detailSoalModal{{ $exam->id }}">
                                                            <i class="fas fa-eye"></i> Lihat Soal
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Modal untuk Detail Soal -->
    @foreach ($exams as $exam)
        <div class="modal fade" id="detailSoalModal{{ $exam->id }}" tabindex="-1" role="dialog"
            aria-labelledby="detailSoalModalLabel{{ $exam->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailSoalModalLabel{{ $exam->id }}">Detail Soal -
                            {{ $exam->title }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if ($exam->questions->isEmpty())
                            <div class="alert alert-info mt-3">Belum ada soal untuk ujian ini.</div>
                        @else
                            <!-- Container untuk menampilkan soal -->
                            <div id="soalContainer{{ $exam->id }}">
                                <!-- Soal akan ditampilkan di sini -->
                            </div>
                            <!-- Pagination -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center" id="pagination{{ $exam->id }}">
                                    <!-- Tombol pagination akan ditambahkan oleh JavaScript -->
                                </ul>
                            </nav>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- Data JSON untuk soal -->
    <script>
        const questionsData = {!! json_encode(
            $exams->map(function ($exam) {
                return [
                    'exam_id' => $exam->id,
                    'questions' => $exam->questions,
                ];
            }),
        ) !!};
    </script>

    <!-- Modal Import Soal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('questions.import') }}" method="POST" enctype="multipart/form-data"
                class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Soal dari Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih Ujian</label>
                        <select name="exam_id" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Ujian --</option>
                            @foreach ($exams as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->title }} - {{ $exam->class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Upload File Excel</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>
                    </div>
                    <p>Silakan upload file Excel sesuai format:</p>
                    <a href="{{ asset('template/template_import_soal.xlsx') }}" class="btn btn-sm btn-info mb-3"
                        target="_blank">
                        <i class="fas fa-download"></i> Download Template
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Import</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

@endsection



@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Loop melalui setiap modal
            questionsData.forEach(examData => {
                const examId = examData.exam_id;
                const questions = examData.questions;
                const soalContainer = document.getElementById(`soalContainer${examId}`);
                const paginationContainer = document.getElementById(`pagination${examId}`);

                let currentPage = 1;
                const questionsPerPage = 2; // Tampilkan 2 soal per halaman

                // Fungsi untuk menampilkan soal berdasarkan halaman
                function displayQuestions(page) {
                    soalContainer.innerHTML = ''; // Kosongkan container soal
                    const startIndex = (page - 1) * questionsPerPage;
                    const endIndex = startIndex + questionsPerPage;

                    // Tampilkan soal untuk halaman saat ini
                    questions.slice(startIndex, endIndex).forEach((question, index) => {
                        const questionHtml = `
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6>Soal ${startIndex + index + 1}:</h6>
                            <p>${question.question_text}</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Opsi A:</strong> ${question.option_a}</p>
                                    <p><strong>Opsi B:</strong> ${question.option_b}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Opsi C:</strong> ${question.option_c}</p>
                                    <p><strong>Opsi D:</strong> ${question.option_d}</p>
                                </div>
                            </div>
                            <p><strong>Jawaban Benar:</strong> ${question.correct_option.toUpperCase()}</p>
                            <!-- Tombol Edit dan Hapus -->
                            <div class="mt-3">
                                <a href="/questions/${question.id}/edit" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                <form action="/questions/${question.id}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus soal ini?')"><i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                `;
                        soalContainer.innerHTML += questionHtml;
                    });
                }

                // Fungsi untuk menampilkan pagination
                function displayPagination() {
                    paginationContainer.innerHTML = ''; // Kosongkan container pagination
                    const totalPages = Math.ceil(questions.length / questionsPerPage);

                    // Tombol Previous
                    const prevItem = document.createElement('li');
                    prevItem.classList.add('page-item');
                    if (currentPage === 1) {
                        prevItem.classList.add('disabled');
                    }
                    const prevLink = document.createElement('a');
                    prevLink.classList.add('page-link');
                    prevLink.href = '#';
                    prevLink.textContent = 'Previous';
                    prevLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (currentPage > 1) {
                            currentPage--;
                            displayQuestions(currentPage);
                            displayPagination();
                        }
                    });
                    prevItem.appendChild(prevLink);
                    paginationContainer.appendChild(prevItem);

                    // Tombol Halaman
                    for (let i = 1; i <= totalPages; i++) {
                        const pageItem = document.createElement('li');
                        pageItem.classList.add('page-item');
                        if (i === currentPage) {
                            pageItem.classList.add('active');
                        }

                        const pageLink = document.createElement('a');
                        pageLink.classList.add('page-link');
                        pageLink.href = '#';
                        pageLink.textContent = i;

                        pageLink.addEventListener('click', function(e) {
                            e.preventDefault();
                            currentPage = i;
                            displayQuestions(currentPage);
                            displayPagination();
                        });

                        pageItem.appendChild(pageLink);
                        paginationContainer.appendChild(pageItem);
                    }

                    // Tombol Next
                    const nextItem = document.createElement('li');
                    nextItem.classList.add('page-item');
                    if (currentPage === totalPages) {
                        nextItem.classList.add('disabled');
                    }
                    const nextLink = document.createElement('a');
                    nextLink.classList.add('page-link');
                    nextLink.href = '#';
                    nextLink.textContent = 'Next';
                    nextLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (currentPage < totalPages) {
                            currentPage++;
                            displayQuestions(currentPage);
                            displayPagination();
                        }
                    });
                    nextItem.appendChild(nextLink);
                    paginationContainer.appendChild(nextItem);
                }

                // Tampilkan soal dan pagination saat modal dibuka
                $(`#detailSoalModal${examId}`).on('shown.bs.modal', function() {
                    displayQuestions(currentPage);
                    displayPagination();
                });
            });
        });
    </script>
@endpush
