@extends('layouts.app')

@section('title', 'Nilai Ujian')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Nilai Ujian</h1>
            </div>
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Ujian</th>
                                <th>Total Soal</th>
                                <th>Benar</th>
                                <th>Nilai (%)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hasilUjian as $hasil)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $hasil['exam']->title ?? '-' }}</td>
                                    <td>{{ $hasil['total'] }}</td>
                                    <td>{{ $hasil['benar'] }}</td>
                                    <td>{{ $hasil['nilai'] }}</td>
                                    <td>
                                        @if ($hasil['nilai'] >= 70)
                                            <span class="badge badge-success">Lulus</span>
                                        @else
                                            <span class="badge badge-danger">Tidak Lulus</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="alert alert-info mt-3">
                                            Belum ada data ujian
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
