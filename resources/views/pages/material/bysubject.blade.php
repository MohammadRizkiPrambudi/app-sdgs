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
                    <div class="col-md-6">
                        <div class="card rounded-box">
                            <div class="card-header">
                                <h4>Daftar Materi </h4>
                            </div>
                            <div class="card-body">
                                @if ($materials->isEmpty())
                                    <div class="alert alert-info">
                                        Belum ada materi
                                    </div>
                                @else
                                    @foreach ($materials as $material)
                                        <div class="list-group">
                                            <a href="{{ route('materials.show', $material->id) }}"
                                                class="list-group-item list-group-item-action">{{ $material->title }}</a>
                                        </div>
                                    @endforeach
                                @endif
                                <a href="{{ route('show.subject') }}" class="btn btn-danger mt-2"><i
                                        class="fas fa-arrow-left mr-1"></i> Kembali</a>
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
