@extends('layouts.app')

@section('title', 'Kerjakan Ujian')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $exam->title }}</h1>
            </div>
            <div class="alert alert-primary alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                    <div class="alert-title">Info</div>
                    Kerjakan Dengan Jujur dan Sebaik-baiknya ya yang terpenting jangan nyontek ya hehe!!!
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Timer -->
                                <div id="timer" class="text-center mb-4">
                                    <div class="alert alert-danger alert-has-icon">
                                        <div class="alert-body">
                                            <h4>Sisa Waktu: <span id="time">00:00</span></h4>
                                        </div>
                                    </div>
                                </div>
                                <!-- Soal -->
                                <div id="soalContainer">
                                    @foreach ($questions as $index => $question)
                                        <div class="soal-group" id="soal{{ $index + 1 }}"
                                            style="{{ $index !== 0 ? 'display:none;' : '' }}">
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h6>Soal {{ $index + 1 }}:</h6>
                                                    <p>{!! $question->question_text !!}</p>
                                                    <div class="form-group">
                                                        <label>Pilih Jawaban:</label>
                                                        <div class="form-check">
                                                            <input type="radio" name="jawaban{{ $question->id }}"
                                                                value="a" class="form-check-input">
                                                            <label class="form-check-label">A.
                                                                {{ $question->option_a }}</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="radio" name="jawaban{{ $question->id }}"
                                                                value="b" class="form-check-input">
                                                            <label class="form-check-label">B.
                                                                {{ $question->option_b }}</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="radio" name="jawaban{{ $question->id }}"
                                                                value="c" class="form-check-input">
                                                            <label class="form-check-label">C.
                                                                {{ $question->option_c }}</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="radio" name="jawaban{{ $question->id }}"
                                                                value="d" class="form-check-input">
                                                            <label class="form-check-label">D.
                                                                {{ $question->option_d }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Pagination -->
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center" id="pagination">
                                        @foreach ($questions as $index => $question)
                                            <li class="page-item">
                                                <a class="page-link" href="#soal{{ $index + 1 }}"
                                                    data-soal="{{ $index + 1 }}">{{ $index + 1 }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </nav>

                                <!-- Tombol Selesai -->
                                <div class="text-center mt-4">
                                    <button id="selesaiBtn" class="btn btn-primary">Selesai</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Timer
        let timeLeft = {{ $remainingTime }}; // Sisa waktu dalam detik

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            document.getElementById('time').textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                submitExam();
            } else {
                timeLeft--;
            }
        }

        // Mulai timer
        const timerInterval = setInterval(updateTimer, 1000);

        document.querySelectorAll('.page-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah perilaku default link

                // Ambil ID soal dari atribut data-soal
                const soalId = this.getAttribute('data-soal');

                // Sembunyikan semua soal
                document.querySelectorAll('.soal-group').forEach(soal => {
                    soal.style.display = 'none';
                });

                // Tampilkan soal yang dipilih
                document.getElementById(`soal${soalId}`).style.display = 'block';
            });
        });

        document.getElementById('selesaiBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda ingin menyelesaikan ujian?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, selesaikan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    submitExam();
                }
            });
        });

        function submitExam() {
            const answers = [];
            document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
                answers.push({
                    question_id: input.name.replace('jawaban', ''),
                    answer: input.value
                });
            });

            fetch("{{ route('exams.submit', $exam) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        answers: answers
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = "{{ route('exams.result', $exam) }}";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Terjadi kesalahan saat mengirim jawaban.', 'error');
                });
        }
    </script>
@endpush
