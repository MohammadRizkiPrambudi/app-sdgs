@extends('layouts.app')

@section('title', 'Data Ujian')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Ujian</h1>
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
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama Ujian</th>
                                                <th class="text-center">Kelas</th>
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($exams as $index => $exam)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td class="text-center">{{ $exam->title }}</td>
                                                    <td class="text-center">
                                                        {{ $exam->class->name }} / {{ $exam->subject->name }}</td>
                                                    <td class="text-center">
                                                        {{ \Carbon\Carbon::parse($exam->start_time)->format('d M Y, H:i') }}
                                                        WIB
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($exam->is_completed)
                                                            <a href="{{ route('exams.result', $exam) }}"
                                                                class="btn btn-success">
                                                                Lihat Nilai
                                                            </a>
                                                        @else
                                                            <button type="button" class="btn btn-primary start-exam-btn"
                                                                data-toggle="modal"
                                                                data-target="#tokenModal{{ $exam->id }}"
                                                                data-start-time="{{ $exam->start_time }}"
                                                                data-end-time="{{ $exam->end_time }}"
                                                                @if (now() < $exam->start_time) title="Ujian belum dimulai" @elseif (now() > $exam->end_time) title="Ujian sudah berakhir" @endif>
                                                                Mulai Ujian
                                                            </button>
                                                        @endif
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
    <!-- Modal untuk Token Ujian -->
    @foreach ($exams as $exam)
        <div class="modal fade" id="tokenModal{{ $exam->id }}" tabindex="-1" role="dialog"
            aria-labelledby="tokenModalLabel{{ $exam->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tokenModalLabel{{ $exam->id }}">Masukkan Token Ujian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('exams.start', $exam) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="token">Token Ujian:</label>
                                <input type="text" name="token" id="token" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Kerjakan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script>
        $(document).ready(function() {
            function checkExamTime(startTime, endTime) {
                const now = new Date();
                const start = new Date(startTime);
                const end = new Date(endTime);
                return now >= start && now <= end;
            }
            $('.start-exam-btn').each(function() {
                const startTime = $(this).data('start-time');
                const endTime = $(this).data('end-time');

                if (!checkExamTime(startTime, endTime)) {
                    $(this).prop('disabled', true);
                }
            });
        });
    </script>
@endpush
