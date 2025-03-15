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
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <button data-toggle="modal" data-target="#modal-tambah"
                                    class="rounded-box btn btn-primary mb-3"><i class="fas fa-plus-circle"></i> Tambah
                                    Ujian</button>
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
                                                <th class="text-center">Token</th>
                                                <th class="text-center">Waktu</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no=1; @endphp
                                            @foreach ($exams as $exam)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $no++ }}
                                                    </td>
                                                    <td>{{ $exam->title }}</td>
                                                    <td>{{ $exam->class->name }}</td>
                                                    <td>{{ $exam->subject->name }}</td>
                                                    <td>{{ $exam->token }}</td>
                                                    <td>{{ $exam->start_time }} - {{ $exam->end_time }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('exams.edit', $exam->id) }}"
                                                            class="btn btn-warning"><i class="fas fa-edit"></i>
                                                            Edit</a>
                                                        <a href="{{ route('exams.destroy', $exam->id) }}"
                                                            class="btn btn-danger" data-confirm-delete="true"><i
                                                                class="fas fa-trash mr-1"></i>Hapus</a>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-tambah">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Ujian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('exams.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Nama Ujian</label>
                            <input type="text" name="title" id="title" placeholder="Nama Ujian"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" placeholder="Description" class="form-control h-25"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="class_id">Kelas:</label>
                            <select name="class_id" id="class_id" class="form-control" required>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subject_id">Mata Pelajaran:</label>
                            <select name="subject_id" id="subject_id" class="form-control" required>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="token">Token Ujian:</label>
                            <input type="text" name="token" id="token" class="form-control"
                                value="Token akan diisi otomatis" readonly>
                        </div>
                        <div class="form-group">
                            <label for="start_time">Waktu Mulai</label>
                            <input type="datetime-local" id="start_time" name="start_time" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="end_time">Waktu Mulai</label>
                            <input type="datetime-local" id="end_time" name="end_time" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fas fa-arrow-left mr-1"></i>Kembali</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Simpan </button>
                    </div>
                </form>
            </div>
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
        $(selector).click(function(e) {
            e.preventDefault();
        });
    </script>
@endpush
