@extends('layouts.app')

@section('title', 'Data Kelas')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Kelas</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('classes.create') }}" class="rounded-box btn btn-primary mb-3"><i
                                        class="fas fa-plus-circle"></i> Tambah
                                    Kelas</a>
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th class="text-center">Kelas</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no=1; @endphp
                                            @foreach ($classes as $class)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $no++ }}
                                                    </td>
                                                    <td class="text-center">{{ $class->name }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('classes.show', $class->id) }}"
                                                            class="btn btn-info"><i class="fas fa-eye mr-1"></i>Lihat</a>
                                                        <a href="{{ route('classes.edit', $class->id) }}"
                                                            class="btn btn-warning"><i class="fas fa-edit mr-1"></i>
                                                            Edit</a>
                                                        <a href="{{ route('classes.destroy', $class->id) }}"
                                                            class="btn btn-danger" data-confirm-delete="true"><i
                                                                class="fas fa-trash mr-1"></i>Hapus</a>
                                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                                            data-target="#addTeacherSubjectModal{{ $class->id }}">
                                                            <i class="fas fa-plus-circle mr-1"></i>Tambahkan Guru & Mapel
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
    @foreach ($classes as $class)
        <!-- Modal untuk Tambah Guru dan Mata Pelajaran -->
        <div class="modal fade" id="addTeacherSubjectModal{{ $class->id }}" tabindex="-1" role="dialog"
            aria-labelledby="addTeacherSubjectModalLabel{{ $class->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTeacherSubjectModalLabel{{ $class->id }}">Tambahkan Guru dan Mata
                            Pelajaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('classes.add_teacher_subject', $class->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="teacher_id">Pilih Guru</label>
                                <select class="form-control select2" id="teacher_id" name="teacher_id" required>
                                    <option value="" disabled selected> --Pilih Guru --</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="subjects">Pilih Mata Pelajaran</label>
                                <select class="form-control select2" id="subjects" name="subjects[]" multiple required>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk modal
            $('.modal').on('shown.bs.modal', function() {
                $(this).find('.select2').select2({
                    placeholder: 'Pilih',
                    allowClear: true,
                    dropdownParent: $(this) // Pastikan dropdown muncul di dalam modal
                });
            });

            // Tutup Select2 saat modal ditutup
            $('.modal').on('hidden.bs.modal', function() {
                $(this).find('.select2').select2('destroy');
            });
        });
    </script>
@endpush
