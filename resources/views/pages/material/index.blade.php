@extends('layouts.app')


@section('title', 'Data Materi')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header rounded-box">
                <h1>Data Materi</h1>
            </div>
            @if ($user->role == 'guru')

                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card rounded-box">
                                <div class="card-header">
                                    <h4>Data Mata Pelajaran Yang Diampu</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table-striped table" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        #
                                                    </th>
                                                    <th class="text-center">Mata Pelajaran</th>
                                                    <th class="text-center">Deskripsi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $no=1; @endphp
                                                @foreach ($subjects as $subject)
                                                    <tr>
                                                        <td class="text-center">{{ $no++ }}</td>
                                                        <td class="text-center">{{ $subject->name }}</td>
                                                        <td class="text-center">{{ $subject->description }}</td>
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
            @endif
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card rounded-box">
                            <div class="card-header">
                                <h4>Data Materi</h4>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('materials.create') }}" class="btn btn-primary rounded-box mb-3"><i
                                        class="fas fa-plus-circle"></i> Tambah
                                    Materi</a>
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-2">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th class="text-center">Judul</th>
                                                <th class="text-center">Kelas</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no=1; @endphp
                                            @foreach ($materials as $material)
                                                <tr>
                                                    <td class="text-center">{{ $no++ }}</td>
                                                    <td class="text-center">{{ $material->title }}</td>
                                                    <td class="text-center">{{ $material->class->name }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('materials.show', $material->id) }}"
                                                            class="btn btn-sm btn-info rounded-box"><i
                                                                class="fas fa-eye mr-1"></i>Lihat</a> <a
                                                            href="{{ route('materials.edit', $material->id) }}"
                                                            class="btn btn-sm btn-warning rounded-box"><i
                                                                class="fas fa-edit mr-1"></i>Edit</a>
                                                        <a href="{{ route('materials.destroy', $material->id) }}"
                                                            class="btn btn-sm btn-danger" data-confirm-delete="true"><i
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
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
