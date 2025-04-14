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
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }

        .info {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <h2>Rekap Nilai Ujian {{ $exam->title }}</h2>

    <div class="info">
        <p><strong>Kelas:</strong> {{ $exam->class->name }} <br>
            <strong>Mapel:</strong> {{ $exam->subject->name }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Siswa</th>
                <th>Benar</th>
                <th>Total Soal</th>
                <th>Nilai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $i => $student)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->correct_answers }}</td>
                    <td>{{ $student->total_questions }}</td>
                    <td>{{ $student->score }}</td>
                    <td>
                        {{ $student->score >= 75 ? 'Lulus' : 'Remedial' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
