@extends('layouts.app')


@section('title', 'Data Materi')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header rounded-box">
                <h1>Data Materi</h1>
            </div>
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
                                    <table class="table-striped table" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>Judul</th>
                                                <th>Kelas</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no=1; @endphp
                                            @foreach ($materials as $material)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $material->title }}</td>
                                                    <td>{{ $material->class->name }}</td>
                                                    <td>
                                                        <a href="{{ route('materials.show', $material->id) }}"
                                                            class="btn btn-info rounded-box">Lihat</a> <a
                                                            href="{{ route('materials.edit', $material->id) }}"
                                                            class="btn btn-warning rounded-box">Edit</a>
                                                        <form action="{{ route('materials.destroy', $material->id) }}"
                                                            method="POST" style="display:inline-block;"> @csrf
                                                            @method('DELETE') <button type="submit" class="btn rounded-box btn-danger"
                                                                data-confirm-delete="true">Hapus</button> </form>
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
