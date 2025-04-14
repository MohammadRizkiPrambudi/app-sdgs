<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Nilai Ujian - {{ $exam->title }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        h2,
        h4 {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <h2>Rekap Nilai Ujian</h2>
    <h4>Judul Ujian: {{ $exam->title }}</h4>
    <h4>Kelas: {{ $exam->class->name }}</h4>
    <h4>Mata Pelajaran: {{ $exam->subject->name }}</h4>
    <hr>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Benar</th>
                <th>Total Soal</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $result)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $result['student']->name }}</td>
                    <td>{{ $result['correct'] }}</td>
                    <td>{{ $result['total'] }}</td>
                    <td>{{ $result['score'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
