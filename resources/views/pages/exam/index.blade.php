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
                                                    <td class="text-center">{{ $exam->title }}</td>
                                                    <td class="text-center">{{ $exam->class->name }} /
                                                        {{ $exam->subject->name }}</td>
                                                    <td class="text-center">{{ $exam->token }}</td>
                                                    <td class="text-center">{{ $exam->start_time }} - {{ $exam->end_time }}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-warning btn-edit"
                                                            data-id="{{ $exam->id }}" data-title="{{ $exam->title }}"
                                                            data-description="{{ $exam->description }}"
                                                            data-class-id="{{ $exam->class_id }}"
                                                            data-subject-id="{{ $exam->subject_id }}"
                                                            data-token="{{ $exam->token }}"
                                                            data-start-time="{{ date('Y-m-d\TH:i', strtotime($exam->start_time)) }}"
                                                            data-end-time="{{ date('Y-m-d\TH:i', strtotime($exam->end_time)) }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
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
                            <label for="class_id">Kelas</label>
                            <select name="class_id" id="class_id" class="form-control" required>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            @if ($user->role === 'teacher')
                                <small class="text-muted">* Hanya kelas yang Anda ampu yang ditampilkan</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="subject_id">Mata Pelajaran</label>
                            <select name="subject_id" id="subject_id" class="form-control" required>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                            @if ($user->role === 'teacher')
                                <small class="text-muted">* Hanya mapel yang Anda ampu yang ditampilkan</small>
                            @endif
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
                            <label for="end_time">Waktu Selesai</label>
                            <input type="datetime-local" id="end_time" name="end_time" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fas fa-arrow-left mr-1"></i>Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Simpan </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-edit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Ujian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_title">Nama Ujian</label>
                            <input type="text" name="title" id="edit_title" placeholder="Nama Ujian"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Deskripsi</label>
                            <textarea name="description" id="edit_description" placeholder="Deskripsi" class="form-control h-25"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_class_id">Kelas:</label>
                            <select name="class_id" id="edit_class_id" class="form-control" required>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_subject_id">Mata Pelajaran:</label>
                            <select name="subject_id" id="edit_subject_id" class="form-control" required>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_token">Token Ujian:</label>
                            <input type="text" name="token" id="edit_token" class="form-control" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit_start_time">Waktu Mulai</label>
                            <input type="datetime-local" id="edit_start_time" name="start_time" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="edit_end_time">Waktu Selesai</label>
                            <input type="datetime-local" id="edit_end_time" name="end_time" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fas fa-arrow-left mr-1"></i>Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Simpan
                        </button>
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
        $(document).ready(function() {
            // Tangani klik tombol edit
            $('.btn-edit').click(function() {
                var examId = $(this).data('id');
                var formAction = "{{ route('exams.update', ':id') }}".replace(':id', examId);

                // Isi form dengan data dari tombol
                $('#edit-form').attr('action', formAction);
                $('#edit_title').val($(this).data('title'));
                $('#edit_description').val($(this).data('description'));
                $('#edit_class_id').val($(this).data('class-id'));
                $('#edit_subject_id').val($(this).data('subject-id'));
                $('#edit_token').val($(this).data('token'));
                $('#edit_start_time').val($(this).data('start-time'));
                $('#edit_end_time').val($(this).data('end-time'));

                // Tampilkan modal
                $('#modal-edit').modal('show');
            });

            // Inisialisasi DataTable
            $('#table-1').DataTable();
        });
    </script>
@endpush
