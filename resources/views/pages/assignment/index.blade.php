@extends('layouts.app')

@section('title', 'Data Tugas')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Tugas</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Data Tugas</h4>
                            </div>
                            <div class="card-body">

                                <a href="{{ route('assignments.create') }}" class="btn btn-primary mb-3"><i
                                        class="fas fa-plus-circle"></i> Tambah
                                    Tugas</a>
                                @if ($assignments->isEmpty())
                                    <p>Belum ada tugas</p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table-striped table" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        #
                                                    </th>
                                                    <th class="text-center">Judul</th>
                                                    <th class="text-center">Deskripsi</th>
                                                    <th class="text-center">Kelas</th>
                                                    <th class="text-center">Mata Pelajaran</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $no=1; @endphp
                                                @foreach ($assignments as $assignment)
                                                    <tr>
                                                        <td class="text-center">{{ $no++ }}</td>
                                                        <td class="text-center">{{ $assignment->title }}</td>
                                                        <td class="text-center">{{ $assignment->description }}</td>
                                                        <td class="text-center">{{ $assignment->class->name }}</td>
                                                        <td class="text-center">{{ $assignment->subject->name }}</td>
                                                        <td class="text-center">
                                                            <a href="{{ route('assignments.edit', $assignment->id) }}"
                                                                class="btn btn-sm btn-warning"><i
                                                                    class="fas fa-edit mr-1"></i>Edit</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
